<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        return view('reports.index', ['canViewBookReport' => ! $request->user()->isPrincipal()]);
    }

    public function print(Request $request, string $type): View
    {
        $this->ensureReportAccess($request, $type);

        return view('reports.print', [
            'type' => $type,
            'bukus' => $type === 'buku' ? Buku::with(['kategori', 'rak'])->latest()->get() : collect(),
            'peminjamans' => $type === 'peminjaman' ? Peminjaman::with(['anggota', 'buku'])->latest()->get() : collect(),
        ]);
    }

    public function excel(Request $request, string $type): Response
    {
        $this->ensureReportAccess($request, $type);

        $rows = $type === 'buku'
            ? Buku::with(['kategori', 'rak'])->latest()->get()->map(fn (Buku $buku) => [
                $buku->kode_buku, $buku->judul, $buku->penulis, $buku->penerbit,
                $buku->kategori?->nama ?? '-', $buku->rak?->kode_rak ?? '-', $buku->stok,
            ])
            : Peminjaman::with(['anggota', 'buku'])->latest()->get()->map(fn (Peminjaman $peminjaman) => [
                $peminjaman->anggota->nama, $peminjaman->buku->judul,
                $peminjaman->tanggal_pinjam->format('Y-m-d'),
                $peminjaman->batas_pengembalian->format('Y-m-d'),
                $peminjaman->tanggal_dikembalikan?->format('Y-m-d') ?? '-',
                $peminjaman->status, $peminjaman->denda,
            ]);

        $headings = $type === 'buku'
            ? ['Kode', 'Judul', 'Penulis', 'Penerbit', 'Kategori', 'Rak', 'Stok']
            : ['Anggota', 'Buku', 'Tanggal Pinjam', 'Batas Kembali', 'Tanggal Kembali', 'Status', 'Denda'];
        $xml = $this->spreadsheetXml($headings, $rows->all());

        return response($xml, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=laporan-{$type}.xls",
        ]);
    }

    private function spreadsheetXml(array $headings, array $rows): string
    {
        $row = fn (array $values): string => '<Row>'.collect($values)->map(fn ($value) => '<Cell><Data ss:Type="String">'.e((string) $value).'</Data></Cell>')->implode('').'</Row>';

        return '<?xml version="1.0"?><?mso-application progid="Excel.Sheet"?>'
            .'<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">'
            .'<Worksheet ss:Name="Laporan"><Table>'.$row($headings).collect($rows)->map($row)->implode('').'</Table></Worksheet></Workbook>';
    }

    private function ensureReportAccess(Request $request, string $type): void
    {
        abort_unless(in_array($type, ['buku', 'peminjaman'], true), 404);
        abort_if($request->user()->isPrincipal() && $type !== 'peminjaman', 403);
    }
}
