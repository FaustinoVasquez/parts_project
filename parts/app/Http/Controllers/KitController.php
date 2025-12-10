<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorekitRequest;
use App\Http\Requests\UpdatekitRequest;
use App\Http\Resources\KitResource;
use App\Models\Category;
use App\Models\Country;
use App\Models\Kit;
use App\Models\KitsData;
use App\Models\PartList;
use App\Models\SubCategory;
use App\Models\WorkCenter;
use App\Services\ReferenceDataCache;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class KitController extends Controller
{
    /**
     * Full-text searchable columns (indexed in SQL Server on base table prt.partskitdata)
     */
    private array $fullTextColumns = ['brand', 'model', 'lcn', 'kitlcn', 'keywords'];

    /**
     * Additional columns to search with LIKE (not in Full-Text index)
     * These are columns from the VIEW that aren't in the base table's Full-Text index
     */
    private array $likeSearchColumns = ['shelf_name', 'boxname'];

    /**
     * Escape special characters for Full-Text Search
     */
    private function escapeFullTextSearch(string $term): string
    {
        // Remove Full-Text special characters that could cause errors
        $specialChars = ['"', '-', '&', '|', '!', '(', ')', '{', '}', '[', ']', '^', '~', '*', '?', ':', '\\', '/'];
        $term = str_replace($specialChars, ' ', $term);
        // Clean up multiple spaces
        $term = preg_replace('/\s+/', ' ', trim($term));
        return $term;
    }

    /**
     * Build Full-Text Search condition for SQL Server
     * Uses CONTAINS() on base table via subquery, since Full-Text index is on prt.partskitdata
     * not on the view prt.vw_PartsKitData
     */
    private function applyFullTextSearch($query, string $searchValue)
    {
        $searchValue = trim($searchValue);
        if (empty($searchValue)) {
            return $query;
        }

        // Check if search is purely numeric (likely a KitID)
        if (is_numeric($searchValue)) {
            // Exact KitID match (very fast with B-tree index)
            return $query->where(function ($q) use ($searchValue) {
                $q->where('kitid', '=', (int)$searchValue)
                  ->orWhereRaw("CAST(kitid AS NVARCHAR(50)) LIKE ?", ['%' . $searchValue . '%']);
            });
        }

        // Escape and prepare search term for Full-Text
        $escapedTerm = $this->escapeFullTextSearch($searchValue);
        if (empty($escapedTerm)) {
            return $query;
        }

        // Build Full-Text search terms with prefix wildcard for partial matches
        $words = explode(' ', $escapedTerm);
        $containsTerms = [];
        foreach ($words as $word) {
            if (strlen($word) >= 2) {
                // Use prefix wildcard to match partial words (e.g., "son*" matches "sony")
                $containsTerms[] = '"' . $word . '*"';
            }
        }

        if (empty($containsTerms)) {
            return $query;
        }

        // Join with AND for multi-word searches
        $containsQuery = implode(' AND ', $containsTerms);

        // Use subquery to search the BASE TABLE (prt.partskitdata) with Full-Text
        // then filter the view by matching KitIDs
        // Note: Column names in base table are PascalCase: Brand, Model, LCN, KitLCN, Keywords
        // Also include LIKE search on view columns not in Full-Text index (shelf_name, boxname)
        $likePattern = '%' . $escapedTerm . '%';

        $query->where(function ($q) use ($containsQuery, $likePattern) {
            // Full-Text search on indexed columns (fast)
            $q->whereRaw(
                "kitid IN (SELECT KitID FROM [prt].[partskitdata] WHERE CONTAINS((Brand, Model, LCN, KitLCN, Keywords), ?))",
                [$containsQuery]
            );

            // LIKE fallback for columns not in Full-Text index (shelf_name, boxname)
            foreach ($this->likeSearchColumns as $column) {
                $q->orWhere($column, 'LIKE', $likePattern);
            }
        });

        return $query;
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     * @throws \Yajra\DataTables\Exceptions\Exception
     */
    public function index(Request $request): View|Factory|JsonResponse|Application
    {

        if ($request->ajax()) {

            if (auth()->user()->role == 'employee') {
                $data = KitsData::query()->where('UserID', auth()->id());
            } else {
                $data = KitsData::query();
            }

            if($request->model !== '0'){
                $data->where('model', $request->model);
            }

            $self = $this; // Capture $this for closure
            $searchValue = $request->input('search.value');

            return datatables($data)
                ->addIndexColumn()
                // Override global search to use Full-Text Search
                // Note: columns must have searchable:false in JS config to prevent DataTables adding LIKE filters
                ->filter(function ($query) use ($searchValue, $self) {
                    if (!empty($searchValue)) {
                        $self->applyFullTextSearch($query, $searchValue);
                    }
                }, true)
                ->editColumn('boxname', function ($kit) {
                    if(!$kit->BoxName){
                        return 'No Box Yet';
                    }
                    return $kit->BoxName;
                })
                ->editColumn('keywords', function ($kit) {
                    if(!$kit->keywords){
                        return 'No Keywords Yet';
                    }
                    return $kit->keywords;
                })
                ->editColumn('shelf_name', function ($kit) {
                    if(!$kit->shelf_name){
                        return 'No Shelf Yet';
                    }
                    return $kit->shelf_name;
                })
                ->editColumn('created_at', function ($kit) {
                    return $kit->created_at->toDateTimeString();
                })
                ->addColumn('actions', function () {
                    $btns ='<div class="btn-group btn-group-sm">
                            <a href="#" class="btn btn-info qrcode"><i class="fas fa-fw fa-print"></i></a>
                            <a href="#" class="btn btn-default show-btn"><i class="fas fa-eye"></i></a>';

                        if(auth()->user()->role =='admin'){
                           $btns .='<a href="#" class="btn btn-sm btn-primary sku-btn"><i class="fas fa-fw fa-bolt"></i></a>';
                        }

                    return $btns.'</div>';
                })
                ->rawColumns(['actions'])
                ->setRowId(function ($data) {
                    return $data->kitid;
                })
                ->toJson();
        }

        return view('kits.index',[
            'brands' => Kit::query()->select('Brand')->distinct()->get(),
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('kits.create', [
            'kit' => new Kit,
            'workCenters' => ReferenceDataCache::workCenters(),
            'categories' => ReferenceDataCache::categories(),
            'subCategories' => ReferenceDataCache::subCategories(),
            'countries' => ReferenceDataCache::countries()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorekitRequest $request
     * @return RedirectResponse
     */
    public function store(StorekitRequest $request)
    {
        $kit = $request->createKit();
        $partlist = PartList::select('PartSequence','PartName', 'IsRequired')
            ->orderBy('PartSequence','asc')
            ->where('PartCategoryID', $kit->PartCategoryID)
            ->where('PartSubCategoryID', $kit->PartSubCategoryID)
            ->get()->mapWithKeys(function ($item) {
                return [$item['PartName'] => $item['IsRequired']];
            })->toArray();


        $kit->parts()->delete();


        foreach ($partlist as $partname => $value) {

            $kit->parts()->create([
                'PartName' => $partname,
                'PartWeightOz' => 0,
                'Created' => 0,
                'IsRequired' => $value,
                'UserID' => auth()->id()
            ]);
        }
        $firstPart = $kit->parts->first();

        $exitst = \DB::select("SELECT VerifiedReferenceExist FROM [PartsProcessing].[prt].[sp_GetLCNData]('$kit->LCN')")[0];

        if($exitst->VerifiedReferenceExist ==='1'){
            return redirect()->route('version.index', [
                'LCN' => $kit->LCN
            ]);
        }

        return redirect()->route('parts.edit', $firstPart)
            ->with('status', 'The Kit has been created, successfully, now we will create each part that compose it');;

    }

    /**
     * Display the specified resource.
     *
     * @param Kit $kit
     * @return Application|Factory|View
     */
    public function show(Kit $kit): View|Factory|Application
    {
        $parts = $kit->parts()->orderby('PartName')->get();
        return view('kits.show', compact('kit', 'parts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Kit $kit
     * @return Application|Factory|View
     */
    public function edit(kit $kit): View|Factory|Application
    {
        return view('kits.edit', [
            'kit' => $kit,
            'workCenters' => ReferenceDataCache::workCenters(),
            'categories' => ReferenceDataCache::categories(),
            'subCategories' => ReferenceDataCache::subCategories(),
            'countries' => ReferenceDataCache::countries()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StorekitRequest $request
     * @param Kit $kit
     * @return RedirectResponse
     */
    public function update(StorekitRequest $request, Kit $kit): RedirectResponse
    {

        $request->updateKit($kit);

        return redirect()->route('kit-parts-update.edit', $kit)
            ->with('status', 'The Kit has been updated, successfully, now we will update each part that compose it');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Kit $kit
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Kit $kit)
    {
        try {
            $ret = \DB::select("EXEC [prt].[sp_NukeKit2]'$kit->KitLCN';");
        } catch (Exception $e) {

            $message = $e->getMessage();
            var_dump('Exception Message: '. $message);

            $code = $e->getCode();
            var_dump('Exception Code: '. $code);

            $string = $e->__toString();
            var_dump('Exception String: '. $string);

            exit;
        }

        return response()->json([
            'success' => 'The Kit has been deleted successfully',
        ], 200);

    }
}

//MTC99T0391
//MTC99T0391-KIT
