<?php

namespace App\Http\Controllers\Aset;

use App\Models\Anggota\Pengelola_Aset;
use Illuminate\Http\Request;
use App\Models\Anggota\Anggota;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Anggota\AnggotaController;

class PengelolaAsetController extends AnggotaController
{
    //mendapatkan list anggota pengelola aset, return list anggota pengelola aset
    public function index()
    {
        //get all id pengelola
        $pengelolaGroup = Pengelola_Aset::get();

        //jika ada pengelola, inilah list bukan pengelolanya (untuk pilihan pengelola)
        $bukanPengelolaGroup =
            Anggota::where('anggota.id_status', '=', self::ACTIVE_MEMBER)
            ->whereNotIn('id', function ($query) {
                $query->select('id_anggota')->from('pengelola_aset');
            })
            ->get();

        //id ke string
        foreach ($pengelolaGroup as $pengelola) {
            $pengelola->anggota_pengelola;
            if ($pengelola->anggota_pengelola != NULL) {
                $pengelola->nama = $pengelola->anggota_pengelola->nama;
                $pengelola->status = $this->getStatus($pengelola->anggota_pengelola);
                $pengelola->jabatan = $this->getJabatan($pengelola->anggota_pengelola);
            }
        }

        return view('aset.pengelola_aset', ['pengelolaGroup' => $pengelolaGroup, 'bukanPengelolaGroup' => $bukanPengelolaGroup]);
    }

    //menambah pengelola aset, return list anggota pengelola aset
    public function create(Request $request)
    {
        $Pengelola_Aset = new Pengelola_Aset();
        $Pengelola_Aset->id_anggota = $request->id_anggota;
        $Pengelola_Aset->save();
        return redirect(route('asetPengelolaAset'));
    }

    //menghapus hak pengelola aset, return list anggota pengelola aset
    public function delete(Request $request)
    {
        Pengelola_Aset::get()->where('id', '=', $request->id)->first()->delete();
        return redirect(route('asetPengelolaAset'));
    }

    public function checkPermission()
    {
        //get all id pengelola
        $pengelolaGroup = Pengelola_Aset::get();
        $arrayIdPengelola = [];
        $id_user = Auth::user()->id;
        foreach ($pengelolaGroup as $pengelola) {
            array_push($arrayIdPengelola, $pengelola->id_anggota);
        }
        if (in_array($id_user, $arrayIdPengelola)) {
            return true;
        } else {
            return false;
        }
    }
}
