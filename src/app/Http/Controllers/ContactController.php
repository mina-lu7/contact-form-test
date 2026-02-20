<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('contact.index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $data = $request->validated();

        $data['tel'] = $data['tel1'] . $data['tel2'] . $data['tel3'];

        $category = Category::find($data['categry_id']);

        return view('contact.confirm', compact('data', 'category'));
    }


    public function back(Request $request)
    {
        return redirect('/')->withInput($request->all());
    }

    public function store(ContactRequest $request)
    {
        $data = $request->validated();

        // 電話番号を結合
        $data['tel'] = $data['tel1'] . $data['tel2'] . $data['tel3'];

        // 分割フィールドはDBに不要なので削除
        unset($data['tel1'], $data['tel2'], $data['tel3']);

        Contact::create($data);

        return redirect('/thanks');
    }
}
