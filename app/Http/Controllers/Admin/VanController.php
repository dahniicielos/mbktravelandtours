<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Van;
use App\Http\Requests\VanAddFormRequest;
use App\Http\Requests\VanEditFormRequest;

class VanController extends Controller
{
    public function add_van(VanAddFormRequest $request)
    {
    	$van_image = $request->van_image;
    	$van_image_src;
        if(!empty($van_image)){
        	$filename = $van_image->store('assets/images', 'uploads');
            $van_image_src = $filename;
        }


    	$van = new Van(array(
            'brand' => $request->get('brand'),
            'model' => $request->get('model'),
            'no_of_seats' => $request->get('no_of_seats'),
            'description' => $request->get('description'),
            'van_image' => $van_image_src
        ));

        $van->save();
        return redirect('/admin/pages/van')->with('status', $request->get('brand').' ('.$request->get('model').')'.' has been successfully added.');
    }


    public function update_van($id, VanEditFormRequest $request)
    {
    	$van = Van::where('id', $id)->firstOrFail();
        $van->brand = $request->get('brand');
        $van->model = $request->get('model');
        $van->no_of_seats = $request->get('no_of_seats');
        $van->description = $request->get('description');

        $van_image = $request->van_image;

        if(!empty($van_image)){
            $filename = $van_image->store('assets/images', 'uploads');
            $van->van_image = $filename;
        }
        $van->save();
        return redirect('/admin/pages/van')->with('status', 'Van has been successfully updated.');
    }

    public function delete_van($id)
    {
    	$van = Van::where('id', $id)->firstOrFail();
        $van->delete();
        return redirect('/admin/pages/van')->with('status', 'Van has been successfully deleted.');
    }
}
