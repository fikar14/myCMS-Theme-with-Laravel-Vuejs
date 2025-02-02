<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProkumDaerah;

class ProkumDaerahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $prokumda = ProkumDaerah::latest()->paginate(10);             
        
        return view('produk-hukum-daerah.index', ['prokumda'=>$prokumda]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('produk-hukum-daerah.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Validator::make($request->all(),[
            "bentuk" => "required|min:4|max:100",
            "no_per" => "required|min:2|max:100",
            "tahun" => "required|min:4|max:100",
            "judul" => "required|min:4|max:100",
            "katalog" => "required|min:1|max:255",
            "abstrak" => "required|min:1|max:255",
            "status" => "required|min:4|max:100",
            ])->validate();

            if($request->hasFile('file')) {
                // Get filename with extension            
                $filenameWithExt = $request->file('file')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);            
                // Get just ext
                $extension = $request->file('file')->getClientOriginalExtension();
                //Filename to store
                $fileNameToStore = $filename.'_'.time().'.'.$extension;                       
                // Upload Image
                $path = $request->file('file')->storeAs('public/prokumda', $fileNameToStore);
            } else {
                $fileNameToStore = 'nofile';
            }

            if($request->hasFile('lampiran')) {
                // Get filename with extension            
                $filenameWithExt = $request->file('lampiran')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);            
                // Get just ext
                $extension = $request->file('lampiran')->getClientOriginalExtension();
                //Filename to store
                $lampiranNameToStore = $filename.'_'.time().'.'.$extension;                       
                // Upload Image
                $path = $request->file('lampiran')->storeAs('public/lampiran', $fileNameToStore);
            } else {
                $lampiranNameToStore = 'nofile';
            }

            $prokumda = ProkumDaerah::firstOrCreate([
                'bentuk' => $request->bentuk,
                'no_per' => $request->no_per,
                'tahun' => $request->tahun,
                'judul' => $request->judul,
                'katalog' => $request->katalog,
                'abstrak' => $request->abstrak,
                'status' => $request->status,
                'file' => $fileNameToStore,
                'lampiran' => $lampiranNameToStore,
            ]);
            
            return redirect()->route('produk-hukum-daerah.index')->with('status', 'Produk Hukum Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prokumda = ProkumDaerah::findOrFail($id);
        return view('produk-hukum-daerah.edit', compact('prokumda'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        \Validator::make($request->all(),[
            "bentuk" => "required|min:4|max:100",
            "no_per" => "required|min:2|max:100",
            "tahun" => "required|min:4|max:100",
            "judul" => "required|min:4|max:100",
            "katalog" => "required|min:1|max:255",
            "abstrak" => "required|min:1|max:255",
            "status" => "required|min:4|max:100",
            ])->validate();
                
            if($request->hasFile('file')) {
                // Get filename with extension            
                $filenameWithExt = $request->file('file')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);            
                // Get just ext
                $extension = $request->file('file')->getClientOriginalExtension();
                //Filename to store
                $fileNameToStore = $filename.'_'.time().'.'.$extension;                       
                // Upload Image
                $path = $request->file('file')->storeAs('public/prokumda', $fileNameToStore);
            } else {
                $fileNameToStore = 'nofile';
            }

            if($request->hasFile('lampiran')) {
                // Get filename with extension            
                $filenameWithExt = $request->file('lampiran')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);            
                // Get just ext
                $extension = $request->file('lampiran')->getClientOriginalExtension();
                //Filename to store
                $lampiranNameToStore = $filename.'_'.time().'.'.$extension;                       
                // Upload Image
                $path = $request->file('lampiran')->storeAs('public/lampiran', $fileNameToStore);
            } else {
                $lampiranNameToStore = 'nofile';
            }
            $prokumda = ProkumDaerah::findOrFail($id);
            $prokumda->bentuk = $request->bentuk;
            $prokumda->no_per = $request->no_per;
            $prokumda->tahun = $request->tahun;
            $prokumda->judul = $request->judul;
            $prokumda->katalog = $request->katalog;
            $prokumda->abstrak = $request->abstrak;
            $prokumda->status = $request->status;
            $prokumda->file = $fileNameToStore;
            $prokumda->lampiran = $lampiranNameToStore;
            $prokumda->save();

            return redirect()->route('produk-hukum-daerah.index')->with(['success' => 'Update Produk Hukum Berhasil!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prokumda = ProkumDaerah::findOrFail($id);
        $prokumda->delete();

        return redirect()->route('produk-hukum-daerah.index')->with('status', 'Produk Hukum
       Berhasil di delete');
    }

    public function prokumda(Request $request)
    {
        // menangkap data pencarian
		$search = $request->search;
		$search2 = $request->search2;
		$search3 = $request->search3;
		$search4 = $request->search4;
 
        // mengambil data dari table prokumda sesuai pencarian data
        if($search || $search2 || $search3 || $search4){
            $prokumda = ProkumDaerah::where([
                ['bentuk','like',"%".$search."%"],
                ['no_per','like',"%".$search2."%"],
                ['tahun','like',"%".$search3."%"],
                ['judul','like',"%".$search4."%"],
            ])
            ->paginate(10);
            }else{
            $prokumda = ProkumDaerah::latest()->paginate(10);
        }

        return view('produk-hukum-daerah.prokumda', ['prokumda' => $prokumda]);
    }

    public function search(Request $request)
    {
        // menangkap data pencarian
		$search = $request->search;
		$search2 = $request->search2;
		$search3 = $request->search3;
		$search4 = $request->search4;
 
        // mengambil data dari table prokumda sesuai pencarian data
        if($search || $search2 || $search3 || $search4){
            $prokumda = ProkumDaerah::where([
                ['bentuk','like',"%".$search."%"],
                ['no_per','like',"%".$search2."%"],
                ['tahun','like',"%".$search3."%"],
                ['judul','like',"%".$search4."%"],
            ])
            ->paginate(10);
        }
        else{
            $prokumda = ProkumDaerah::latest()->paginate(10);
        }

        return view('produk-hukum-daerah.index',['prokumda' => $prokumda]);
    }
}
