<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Validator;

class AudioController extends Controller
{
    function serve($filename)
    {
        $disk = Storage::disk('local');
        $path = "audios/$filename";

        if (!$disk->exists($path))
            abort(404);

        /**
         * Consider adding
         * BinaryFileResponse::trustXSendfileTypeHeader();
         * before returning a response
         */

        $path = storage_path("app/$path");
        return new BinaryFileResponse($path);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    function handleUpload(Request $request){
        $allowed_extensions = ['mp3', 'ogg'];
        $allowed_mime_types = ['audio/*'];
        $max_size = (int)ini_get('upload_max_filesize') * 1000;

        $this->validate($request,[
            'audio_file' => [
                "required",
                "file",
                "mimetypes:" . implode(',', $allowed_mime_types),
                "max:" . $max_size
            ]
        ]);

        $file = $request->file('audio_file');

        if (!$file->isValid()) {
            abort(400,'Invalid file submitted');
        }

        if (!in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
            abort('Invalid file type submitted');
        }

        $path = $file->storeAs('audios', $file->getClientOriginalName());

        return response()->json(['path' => $path]);
    }

}
