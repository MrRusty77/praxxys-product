<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Models\Categories;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Categories', []);
    }

    public function get(Request $data)
    {
        $data = $data->all();

        $categories = Categories::get($data);

        $categories->select(
            'c.id as category_id',
            'c.name',
            'c.created_at',
        );

        return $categories->where('c.status', '=', 'active')->get();
    }

    public function search(Request $data)
    {
        $data = $data->all();

        $categories = Categories::get($data);

        $categories->select(
            'c.id as category_id',
            'c.name',
            'c.created_at',
        );

        if (isset($data['keyword'])) {
            $keyword = $data['keyword'];

            $categories->where(function ($query) use ($keyword) {
                $query->orWhere('c.name', 'LIKE', "%$keyword%");
            });
        }

        return $categories
            ->where('c.status', '=', 'active')
            ->paginate(10);
        // return $users->get();

    }

    public function AddOrUpdate(Request $data)
    {

        $val = self::validateInput($data->all());

        if (isset($val['error']))
            return response()->json((array) $val, 401);

        if (isset($data['category_id']))
            return response()->json(Categories::updateCategory($data->all()));
        else
            return response()->json(Categories::createCategory($data->all()));
    }

    public static function validateInput($data)
    {

        $messages = [
            'name.required'    => 'Please Enter Category Name!',
        ];


        $validate_data =  [
            'name'    => 'required|alpha|min:2|max:255',
        ];

        $validator = Validator::make($data, $validate_data, $messages);

        if ($validator->fails())
            return $validator->validate();
        else
            return true;
    }

    public static function removeCategory(Request $data)
    {
        $val = self::validateRemoveCategoryInput($data->all());

        if (!isset($val['error']))
            return Categories::removeCategory($data->all());
        else
            response()->json((array) $val, 404);
    }

    public static function validateRemoveCategoryInput($data)
    {
        $validator = Validator::make($data, ['category_id' => 'required'], ['category_id.required' => 'Please select cathegory']);

        if ($validator->fails()) {
            return $validator->validate();
        } else {
            return true;
        }
    }
}
