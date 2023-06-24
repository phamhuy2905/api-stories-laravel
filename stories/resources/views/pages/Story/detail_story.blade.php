@extends('layouts.DefaultLayout')
@section('content')

<div class="grid grid-cols-3 gap-4 ">
    <div class="flex flex-col">
        <label class="my-4" for="">Name</label>
        <input class="py-2 px-1 border-2 border-gray-200 " type="text" value="{{$data->name}}" disabled>
    </div>
    <div class="flex flex-col">
        <label class="my-4" for="">Name author</label>
        <input class="py-2 px-1 border-2 border-gray-200 " type="text" value="{{$data->name_author}}" disabled>
    </div>
    <div class="flex flex-col">
        <label class="my-4" for="">Publisher</label>
        <input class="py-2 px-1 border-2 border-gray-200 " type="text" value="{{$data->publisher->name}}" disabled>
    </div>
    <div class="flex flex-col">
        <label class="my-4" for="">Category</label>
        <input class="py-2 px-1 border-2 border-gray-200 " type="text" value="{{$data->category->name}}" disabled>
    </div>
    <div class="flex flex-col">
        <label class="my-4" for="">Create at</label>
        <input class="py-2 px-1 border-2 border-gray-200 " type="text" value="{{$data->created_at}}" disabled>
    </div>
    <div class="flex flex-col">
        <label class="my-4" for="">Delete</label>
        <input class="py-2 px-1 border-2 border-gray-200 " type="text" value="{{$data->isDeleted}}" disabled>
    </div>

  
</div>
<div class="grid grid-cols-1 mt-5">
    <div class="flex flex-col">
        <label class="my-4" for="">Description short</label>
        <textarea class="p-2 border-[#ddd] border-2 rounded-[10px] outline-blue-500" name="description_long" id="" cols="30" rows="3">{{  $data->description_short }}</textarea>
    </div>
    <div class="flex flex-col">
        <label class="my-4" for="">Description long</label>
        <textarea class="p-2 border-[#ddd] border-2 rounded-[10px] outline-blue-500" name="description_long" id="" cols="30" rows="10">{{  $data->description_long }}</textarea>
    </div>

    <div class="flex flex-col">
        <label class="my-4" for="">Thumbnail</label>
        <img src="{{ url($data->thumbnail) }}" class="rounded mr-75 border-primary show_img" alt="profile image" height="200" width="200" style="object-fit: cover" class="show_img" id="show_img">
    </div>

    <div class="flex flex-col">
        <label class="my-4" for="">Trailer</label>
            <video  width="320" height="240" controls>
                <source src="{{ url($data->trailer) }}">
            </video>
    </div>
</div>
@endsection
