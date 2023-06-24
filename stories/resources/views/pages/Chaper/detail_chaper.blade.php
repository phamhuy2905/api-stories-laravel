@extends('layouts.DefaultLayout')
@section('content')

<div class="grid grid-cols-2 gap-4 ">
    <div class="flex flex-col">
        <label class="my-4" for="">Name</label>
        <input class="py-2 px-1 border-2 border-gray-200 " type="text" value="{{$data->name}}" disabled>
    </div>
    <div class="flex flex-col">
        <label class="my-4" for="">Story</label>
        <input class="py-2 px-1 border-2 border-gray-200 " type="text" value="{{$data->story->name}}" disabled>
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
        <label class="my-4" for="">Thumbnail</label>
        <img src="{{ url($data->thumbnail) }}" class="rounded mr-75 border-primary show_img" alt="profile image" height="200" width="200" style="object-fit: cover" class="show_img" id="show_img">
      </div>

    <div class="flex flex-col">
        <label class="my-4" for="">Description </label>
        <textarea class="p-2 border-[#ddd] border-2 rounded-[10px] outline-blue-500" name="description_long" id="" cols="30" rows="10">{{  $data->description }}</textarea>
    </div>
</div>
@endsection
