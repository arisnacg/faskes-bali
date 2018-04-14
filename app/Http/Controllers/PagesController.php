<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use Zipper;
use File;
use App\App;
use App\Employee;
use App\Partner;
use App\Contract;
use App\Facility;

use Illuminate\Http\Request;

class PagesController extends Controller
{

    public function index(){
        return view('dashboard')
            ->with('user', User::with('employee')->find(Auth::user()->id))
            ->with('app', App::first())
            ->with('num_employee', count(Employee::all()))
            ->with('num_partner', count(Partner::all()))
            ->with('num_contract', count(Contract::all()))
            ->with('num_facility', count(Facility::all()));
    }

    public function pengaturan(){
    	return view('pengaturan')
    		->with('user', User::with('employee')->find(Auth::user()->id))
            ->with('app', App::first());
    }

    public function ubah(Request $req){
        $this->validate($req, [
            'name' => 'required'
        ]);

        $app = App::first();

        $app->name = $req->name;

        if($req->hasFile('image') && $req->file('image')->isValid()){
            $filename = 'logo.png';
            $req->image->move(base_path('public/images/'), $filename);

            $app->logo = $filename;
        }

        $app->save();

        return redirect('/pengaturan');
    }

    public function pengguna(){
    	return view('kelola_user')
    		->with('user', User::with('employee')->find(Auth::user()->id))
            ->with('app', App::first());
    }

    public function pegawai(){
    	return view('kelola_pegawai')
    		->with('user', User::with('employee')->find(Auth::user()->id))
            ->with('app', App::first());
    }

    public function rekanan(){
        return view('kelola_rekanan')
            ->with('user', User::with('employee')->find(Auth::user()->id))
            ->with('app', App::first());
    }

    public function kontrak(){
        return view('kelola_kontrak')
            ->with('user', User::with('employee')->find(Auth::user()->id))
            ->with('app', App::first());
    }

    public function faskes(){
        return view('kelola_faskes')
            ->with('user', User::with('employee')->find(Auth::user()->id))
            ->with('app', App::first());
    }

    public function qrcode(){
        return view('kelola_qrcode');
    }

    public function generate(Request $req){

        $this->validate($req, [
            'instansi' => 'required',
            'pemerintah' => 'required',
            'tahun' => 'required',
            'max' => 'required',
            'min' => 'required'
        ]);

        $kode = $req->instansi."/".$req->pemerintah."/".$req->tahun."/";
        $kode = strtoupper($kode);

        File::cleanDirectory(public_path()."/images/qrcode/");
        File::cleanDirectory(public_path()."/images/zips/");

        $i = $req->min;
        $max = $req->max;

        $renderer = new \BaconQrCode\Renderer\Image\Png();
        $renderer->setHeight(800);
        $renderer->setWidth(800);

        while($i <= $max){
            $writer = new \BaconQrCode\Writer($renderer);
            $writer->writeFile($kode.$i, 'images/qrcode/'.str_replace('/', '_', $kode).'_'.$i.'.png');
            $i++;
        }

        $files = glob('images/qrcode/');
        $filename = str_replace('/', '_', $kode).$req->min.'_'.$req->max.'.zip';
        Zipper::make(public_path().'/zips/'.$filename)->add($files)->close();

        return response()->json([
            'generated' => true,
            'filename' => $filename
        ]);

    }

    public function download($filename){
        $file = public_path(). '/zips/'.$filename;
        return response()->download($file, $filename); 
    }

    public function pencarian_pegawai(){
        return view('pencarian_pegawai')
            ->with('user', User::with('employee')->find(Auth::user()->id))
            ->with('app', App::first());
    }

    public function pencarian_rekanan(){
        return view('pencarian_rekanan')
            ->with('user', User::with('employee')->find(Auth::user()->id))
            ->with('app', App::first());
    }

    public function pencarian_kontrak(){
        return view('pencarian_kontrak')
            ->with('user', User::with('employee')->find(Auth::user()->id))
            ->with('app', App::first());
    }

    public function pencarian_faskes(){
        return view('pencarian_faskes')
            ->with('user', User::with('employee')->find(Auth::user()->id))
            ->with('app', App::first());
    }

    public function pencarian_rambu(){
        return view('pencarian_rambu')
            ->with('user', User::with('employee')->find(Auth::user()->id))
            ->with('app', App::first());
    }
}
