<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Models\Symbol;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use SplFileObject;
use ZipArchive;

final class FileTools
{
    public function download(string $from, ?string $to = null): string
    {
        $to = $to ?: pathinfo($from, PATHINFO_BASENAME);
        $content = Http::get($from)->body();
        Storage::put($to, $content);

        return Storage::path($to);
    }

    /**
     * @throws Exception
     */
    public function unzip(string $from, ?string $to = null): string
    {
        $to = $to ?: pathinfo($from, PATHINFO_FILENAME);
        $fullPath = Storage::path($to);
        $zip = new ZipArchive();
        $zipFile = $zip->open($from);
        if ($zipFile === false) {
            throw new Exception('Open zip is failed.');
        }
        Storage::deleteDirectory($to);

        $result = $zip->extractTo($fullPath);
        if ($result === false) {
            throw new Exception('Extract zip is failed.');
        }
        $zip->close();
        return $fullPath;
    }

    public function getRate(string $from): array
    {
        $file = new SplFileObject($from);
        $file->setFlags(SplFileObject::READ_CSV);
        $result = [];
        foreach ($file as $row) {
            list($from, $to, , $sendCurrency, $receiveCurrency) = explode(';', $row[0]);
            $sum = $sendCurrency / $receiveCurrency;
            if (isset($result[$from][$to])) {
                $resultData = $sendCurrency / $receiveCurrency;
                if ($sum < $resultData) {
                    $sum = $resultData;
                }
            }
            $result[$from][$to] = round($sum, 20);
        }
        return $result;
    }
    public function updateOrCreateSymbols(string $filePath): void
    {
        $file = new SplFileObject($filePath);
        $file->setFlags(SplFileObject::READ_CSV);
        foreach ($file as $row) {
            [$code, $symbol] = explode(';', $row[0]);
            Symbol::updateOrCreate(['code' => $code], ['symbol' => $symbol]);
        }
    }
}
