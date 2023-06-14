<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
//import
use App\Helpers\ApiFormatter;
use Exception;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //ambil data dari key search_nama bagian paramsnya postman
        $search = $request->search_nama;
        //ambil data dari key limit bagian params nya postman
        $limit = $request->limit;
        //cari data berdasarkan yang di search
        $students = Student::where('nama', 'LIKE', '%'.$search.'%')->limit($limit)->get();
        // ambil semua data melalui model
       // $students = Student::all();
        if ($students) {
            //kalau data berhasil diambil
            return ApiFormatter::createAPI(200, 'success', $students);
    }else {
            //kalau data gagal di ambil
            return ApiFormatter::createAPI(400, 'failed');
    }
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try{
            //untuk validasi
        $request->validate([
            'nama' => 'required|min:3',
            'nis' => 'required|numeric',
            'rombel' => 'required',
            'rayon' => 'required',
        ]);

        //ngirim data baru ke table students lewat model student
        $student = Student::create([
            'nama' => $request->nama,
            'nis' => $request->nis,
            'rombel' => $request->rombel,
            'rayon' => $request->rayon,
        ]);

        //cari data baru yang berhasil di simpen, cari berdasarkan id lwat data id dari $student yg di atas
        $hasilTambahData = Student::where('id', $student->id)->first();
        if ($hasilTambahData) {
            return ApiFormatter::createAPI(200, 'success', $student);
        } else {
            return ApiFormatter::createAPI(400, 'failed');
        }
    } catch(Exception $error) {
        //utuk munculin deskripsi erorr yg bakal tampil di property data jsonnya
        return ApiFormatter::createAPI(400, 'error', $error->getMessage());
    }
}

public function createToken ()
{
    return csrf_token();
}


    public function show($id)
    {
        // coba baris ke dalam try
        try {
            // ambil data dari table students yang id nya sama kayak $id dari patch routenya
            // where & find fungsiny mencari, bedanya : where nyari berdasarkan column apa aja boleh, kalau find cuman bisa cari berdasarkan id
            $student = Student::find($id);
            if ($student) {
                return ApiFormatter::createAPI(200, 'success', $student);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            // kalau pas try ada erorr, deskripsi error yang ditampillkan dengan status code 400
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function edit(Student $student)
    {
        //
    }


    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'nama' => 'required|min:3',
                'nis' => 'required|numeric',
                'rombel' => 'required',
                'rayon' => 'required',
            ]);
            // ambil data yang akan di ubah
            $student = Student::find($id);
            // update data yang telah diambil di atas
            $student->update([
                'nama' => $request->nama,
                'nis' => $request->nis,
                'rombel' => $request->rombel,
                'rayon' => $request->rayon,
            ]); 
            // cari data yg akan berhasil di ubah tadi, cari berdasarkan id dari $student yg ngambil data diawa
            $dataTerbaru = Student::where('id', $student->id)->first();
            if ($dataTerbaru) {
                // jika update berhasil, tampilkan data dari $dataTerbaru diatas (data yg sudah berhasil diubah)
                return ApiFormatter::createAPI(200, 'success', $dataTerbaru);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            //jika baris kode try ada trouble, erorr dimunculkan dengan desc error nya dengan status code 400
            return ApiFormatter::createAPI(400, 'failed', $error->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            // ambil data yang mau dihapus
            $student = Student::findOrFail($id);
            // hapus data yang diambil diatas
            $proses = $student->delete();

            if ($proses) {
                //kalau berhasil dihpaus, data yang munculin teks konfirm dengan status code 200
                return ApiFormatter::createAPI(200, 'succes delete');
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            // kalau ada trouble di baris kode dalem try, error desf nya dimunculin
            return ApiFormatter::createAPI(400, 'failed', $error);
        }
    }

    public function trash()
    {
        try {
            // ambil data yang sdh dihapus sementara
            $students = Student::onlyTrashed()->get();
            if ($students) {
                //kalau data berhasil terambil, tampilkan status 200 dengan dara dari $students
                return ApiFormatter::createAPI(200, 'success', $students);
            } else {
                return ApiFormatter::createAPI (400, 'failed');
            }
        } catch (Exception $error) {
            // kalau ada error di try, catch akan menampilkan desc errornya
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function restore($id) {
        try {
            // ambil data yang akan dihpus
            $student = Student::onlyTrashed()->where('id', $id);
            // kembalikan data
            $student->restore();
            // ambil kembali data yang sudah di restore
            $dataKembali = Student::where('id', $id)->first();
            if ($dataKembali) {
                // jika seluruh prosesnya dapat dijalankan data yang sudah dikembalikan tadi ditampilkan pada response 200
                return ApiFormatter::createAPI(200, 'success', $dataKembali);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function permanenDelete($id)
    {
        try {
            // ambil data yang akan dihapus
            $student = Student::onlyTrashed()->where('id', $id);
            // hapus permanen data yang diambil
            $proses = $student->forceDelete();
           return ApiFormatter::createAPI(200, 'success', 'Berhasil hapus permanen');
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }
}

    