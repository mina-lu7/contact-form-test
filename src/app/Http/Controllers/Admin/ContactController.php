<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::with('category')->paginate(7)->withQueryString();
        $categories = Category::all();

        return view('admin.index', compact('contacts', 'categories'));
    }

    public function search(Request $request)
    {
        $query = Contact::with('category');

        // 名前・メール（部分一致）
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%")
                    ->orWhereRaw("CONCAT(first_name, last_name) LIKE ?", ["%{$keyword}%"])
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$keyword}%"])
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        // 性別（all は絞り込みなし）
        if ($request->filled('gender') && $request->gender !== 'all') {
            $query->where('gender', $request->gender);
        }

        // 種類
        if ($request->filled('category_id')) {
            $query->where('categry_id', $request->category_id);
        }

        // 日付（created_at の日付一致）
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $contacts = $query->paginate(7)->withQueryString();
        $categories = Category::all();

        return view('admin.index', compact('contacts', 'categories'));
    }

    public function show($id)
    {
        $contact = Contact::with('category')->findOrFail($id);

        return response()->json($contact);
    }

    public function destroy(Request $request)
    {
        Contact::findOrFail($request->id)->delete();

        return redirect('/admin')->with('success', '削除しました');
    }

    public function export(Request $request)
    {
        $query = Contact::with('category');

        // 名前・メール（部分一致）
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%")
                    ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ["%{$keyword}%"])
                    ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$keyword}%"])
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        // 性別（all は絞り込みなし）
        if ($request->filled('gender') && $request->gender !== 'all') {
            $query->where('gender', $request->gender);
        }

        // 種類
        if ($request->filled('categry_id')) {
            $query->where('categry_id', $request->category_id);
        }

        // 日付（created_at の日付一致）
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $contacts = $query->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="contacts.csv"',
        ];

        return response()->stream(function () use ($contacts) {
            $out = fopen('php://output', 'w');

            // Excel対策（UTF-8 BOM）
            fwrite($out, "\xEF\xBB\xBF");

            // ヘッダー行
            fputcsv($out, ['お名前', '性別', 'メールアドレス', '電話番号', '住所', '建物名', 'お問い合わせの種類', 'お問い合わせ内容']);

            foreach ($contacts as $c) {
                $gender = $c->gender === 1 ? '男性' : ($c->gender === 2 ? '女性' : 'その他');
                $category = $c->category ? $c->category->content : '';

                fputcsv($out, [
                    $c->last_name . ' ' . $c->first_name,
                    $gender,
                    $c->email,
                    '="' . $c->tel . '"',
                    $c->address,
                    $c->building ?? '',
                    $category,
                    $c->detail,
                ]);
            }

            fclose($out);
        }, 200, $headers);
    }
}
