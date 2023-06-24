@extends('layouts.DefaultLayout')
@section('content')


  </div>
    <form method="POST" action={{route('story.update')}} enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{$data->id}}" name="id">
        <div class="grid grid-cols-1 gap-4">
            <div class="flex flex-col">
                <label class="text-[16px] text-gray-500 my-4" for="name">Name story:</label>
                <input class="py-2 px-4 w-full text-[16px] text-gray-500 outline-blue-500 border-[#ddd] border-2" type="text" name="name" id="name" placeholder="Please name publisher..."  value="{{ $data->name }}">
            </div>

            <div class="flex flex-col">
              <label class="text-[16px] text-gray-500 my-4" for="name_author">Name author:</label>
              <input class="py-2 px-4 w-full text-[16px] text-gray-500 outline-blue-500 border-[#ddd] border-2" type="text" name="name_author" id="name_author" placeholder="Please name author..."  value="{{$data->name_author}}" >
            </div>

            <div class="flex flex-col">
              <label class="text-[16px] text-gray-500 my-4" for="category_id">Category:</label>
              <select class="py-2 border-[#ddd] border-2 rounded-[10px] outline-blue-500" name="category_id" id="">
                @foreach ($category as $index => $each )
                <option @if($data->category_id == $each->id)
                  selected="true"
                  @endif value="{{$each->id}}">{{ $each->name }}</option>
                @endforeach
              </select>
          </div>

          <div class="flex flex-col">
            <label class="text-[16px] text-gray-500 my-4" for="publisher_id">Publisher:</label>
            <select class="py-2 border-[#ddd] border-2 rounded-[10px] outline-blue-500" name="publisher_id" id="publisher_id">
              @foreach ($publisher as $index => $each )
              <option @if($data->publisher_id == $each->id)
                selected="true"
                @endif value="{{$each->id}}">{{ $each->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="flex flex-col">
            <label class="text-[16px] text-gray-500 my-4  " for="description_short">Description short:</label>
            <textarea class="p-2 border-[#ddd] border-2 rounded-[10px] outline-blue-500" name="description_short" id="" cols="30" rows="3"> {{ $data->description_short }}</textarea>
          </div>
          <div class="flex flex-col">
            <label class="text-[16px] text-gray-500 my-4 " for="description_long">Description long:</label>
            <textarea class="p-2 border-[#ddd] border-2 rounded-[10px] outline-blue-500" name="description_long" id="" cols="30" rows="10">{{  $data->description_long }}</textarea>
          </div>

          <div class="flex flex-col">
            <label for="thumbnail" class="text-[16px] text-white my-4 block bg-purple-500 rounded-[10px] py-2 text-center" >Chooose thumbnail:</label>
            <input class="hidden" name="thumbnail" id="thumbnail" type="file">
            <input type="hidden" value="{{$data->thumbnail}}" name="thumbnail_current">
          </div>


          <div class="flex flex-col mt-1">
            <img src="{{ url($data->thumbnail) }}" class="rounded mr-75 border-primary show_img" alt="profile image" height="200" width="200" style="object-fit: cover" class="show_img" id="show_img">
          </div>

          <div class="flex flex-col">
            <label for="trailer" class="text-[16px] text-white my-4 block bg-purple-500 rounded-[10px] py-2 text-center" >Chooose trailer:</label>
            <input class="hidden" name="trailer" id="trailer" type="file">
            <input type="hidden" value="{{$data->trailer}}" name="trailer_current">
          </div>

          <div class="mt-2">
            @foreach ($errors->all() as $error)
              <p class="text-[16px] text-red-500">{{ $error }}</p>
            @endforeach
          </div>
          <button class="bg-blue-500 text-white text-[17px] text-center py-2 rounded-[10px] mt-10">Update story</button>
      </div>
    </form>
@endsection

@push('js')

<script>
    @if (Session::has('message'))
    toastr.success("{{ Session::get('message') }}") 
    @endif


    const file = document.querySelector('#thumbnail');
        const show_img = document.querySelector('#show_img');
        file.addEventListener('change', function(e) {
            const reader = new FileReader();
            reader.onload  = function(e) {
                show_img.src = e.target.result;
            }
            reader.readAsDataURL(e.target.files['0'])
        })

</script>
@endpush