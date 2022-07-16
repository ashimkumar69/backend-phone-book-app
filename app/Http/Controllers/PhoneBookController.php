<?php

namespace App\Http\Controllers;

use App\Http\Resources\PhoneBookResource;
use App\Models\PhoneBook;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class PhoneBookController extends Controller
{
    public function index(): JsonResource
    {
        return PhoneBookResource::collection(PhoneBook::all());
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:phone_books,phone',
            'email' => 'nullable|email',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'address' => 'nullable',
            'long' => 'nullable',
            'lat' => 'nullable',
            'nid' => 'nullable',
        ]);

        if ($validator->fails()) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, $validator->errors());
        }

        $phoneBook = PhoneBook::create($validator->validated());

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $phoneBook->image = storeFile($request->file('image'), 'phone_books', $phoneBook->name);
            $phoneBook->save();
        }

        return (new PhoneBookResource($phoneBook))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PhoneBook $phoneBook): JsonResource
    {
        return new PhoneBookResource($phoneBook);
    }

    public function update(Request $request, PhoneBook $phoneBook): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:phone_books,phone,' . $phoneBook->id,
            'email' => 'nullable|email',
            'address' => 'nullable',
            'long' => 'nullable',
            'lat' => 'nullable',
            'nid' => 'nullable',
        ]);

        if ($validator->fails()) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, $validator->errors());
        }

        $phoneBook->update($validator->validated());

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $validator = Validator::make($request->all(), [
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($validator->fails()) {
                abort(Response::HTTP_UNPROCESSABLE_ENTITY, $validator->errors()->first('image'));
            }

            deleteFile('phone_books/' . getPathInfoBaseName($phoneBook->image ?? ''));

            $phoneBook->image = storeFile($request->file('image'), 'phone_books', $phoneBook->name);
            $phoneBook->save();
        }

        return (new PhoneBookResource($phoneBook))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(PhoneBook $phoneBook): void
    {
        deleteFile('phone_books/' . getPathInfoBaseName($phoneBook->image ?? ''));
        $phoneBook->delete();

        response()->noContent();
    }
}
