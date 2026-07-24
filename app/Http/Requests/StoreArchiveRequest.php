<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArchiveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create archives');
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'archive_date' => ['required', 'date'],
            'classification' => ['required', 'string', 'in:Umum,Internal,Rahasia,Sangat Rahasia'],
            'folder_id' => ['nullable', 'exists:folders,id'],
            'file' => ['required', 'file', 'max:10240', 'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul arsip wajib diisi.',
            'archive_date.required' => 'Tanggal arsip wajib diisi.',
            'classification.required' => 'Klasifikasi wajib dipilih.',
            'file.required' => 'File dokumen wajib diunggah.',
            'file.max' => 'Ukuran file maksimal 10 MB.',
            'file.mimes' => 'Format file harus PDF, DOC, DOCX, XLS, XLSX, JPG, atau PNG.',
        ];
    }
}
