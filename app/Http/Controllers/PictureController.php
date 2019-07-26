<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportCSVRequest;
use App\Pictures;
use Illuminate\Support\Facades\Storage;

class PictureController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('index');
    }

    /**
     * @param ImportCSVRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function import(ImportCSVRequest $request)
    {
        $blank_lines = 0;
        $ignore_lines = 0;
        $row = 0;
        $imported_lines = 0;
        $updated_lines = 0;

        if (($handle = fopen($request->file('file')->getRealPath(), "r")) !== false) {
            while (($data = fgetcsv($handle, 100, "|")) !== false) {

                // skip first line if header field checked
                if (++$row == 1 && $request->header == 1) {
                    continue;
                }

                // if line was empty we will skip and increase $blank_lines for log
                if ($data == null) {
                    $blank_lines++;
                    continue;
                }

                $num = count($data);

                // if the column was less than 3 columns we will sjip and increase the $ignore_lines for log
                if ($num != 3) {
                    $ignore_lines++;
                    continue;
                }

                // create an array to storing in database
                $storing_array = [
                    'title' => trim($data[0]),
                    'url' => trim($data[1]),
                    'description' => trim($data[2]),
                ];

                // check for record existance
                $picture = Pictures::whereTitle($storing_array['title'])->first();
                if ($picture === null) {

                    // validate picture url
                    if (filter_var($storing_array['url'], FILTER_VALIDATE_URL)) {
                        $storing_array['path'] = $this->storePicture($storing_array['url']);
                    }

                    // insert into the database
                    Pictures::create($storing_array);

                    // increase $imported_lines for log
                    $imported_lines++;
                } else {

                    // validate picture url and check for changes
                    if ($storing_array['url'] != $picture->url && filter_var($storing_array['url'],
                            FILTER_VALIDATE_URL)) {
                        $storing_array['path'] = $this->storePicture($storing_array['url'], $picture->path ?? null);
                    }

                    // remove title from array and update picture record
                    array_shift($storing_array);
                    $picture->update($storing_array);

                    // increase $updated_lines for log
                    $updated_lines++;

                }
            }
            fclose($handle);
        }

        return view('result')->with([
            'row' => $row,
            'blank_lines' => $blank_lines,
            'ignore_lines' => $ignore_lines,
            'updated_lines' => $updated_lines,
            'imported_lines' => $imported_lines
        ]);
    }

    /**
     * @param $url
     * @param null $replace_by
     * @return bool|null|string
     */
    public function storePicture($url, $replace_by = null)
    {
        $contents = @file_get_contents($url);
        if ($contents !== false && Storage::put('public/' .$name = substr($url, strrpos($url, '/') + 1), $contents)) {

            // remove old file
            if ($replace_by !== null) {
                Storage::delete($replace_by);
            }

            return $name;
        }

        return null;
    }
}
