@extends('layouts.DefaultLayout')
@section('content')

<div class="flex justify-end my-4">
    <a href="/story/add" class="text-right text-[18px] text-white px-10 py-2 bg-green-500 rounded-[10px]">Add story</a>
</div>
<div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <table class="min-w-full text-center text-sm font-light">
            <thead
              class="border-b bg-blue-500 font-medium text-white dark:border-neutral-500 dark:bg-neutral-900">
              <tr>
                <th scope="col" class=" px-6 py-4">#</th>
                <th scope="col" class=" px-6 py-4">Name</th>
                <th scope="col" class=" px-6 py-4">Name Author</th>
                <th scope="col" class=" px-6 py-4">Image</th>
                <th scope="col" class=" px-6 py-4">Edit</th>
                <th scope="col" class=" px-6 py-4">Delete</th>
                <th scope="col" class=" px-6 py-4">Detail</th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-b dark:border-neutral-500">
                @foreach ($data as $index => $each )
                <tr>
                    <td class="whitespace-nowrap  px-6 py-4 font-medium">{{ $index + 1 }}</td>
                    <td class="whitespace-nowrap  px-6 py-4">{{$each->name}}</td>
                    <td class="whitespace-nowrap  px-6 py-4">{{$each->name_auhthor}}</td>
                    <td class="whitespace-nowrap  px-6 py-4"><img class="w-[100px] h-[100px]" 
                        src="{{url($each->thumbnail)}}" alt="Image Story"></td>
                    <td class="whitespace-nowrap  px-6 py-4 text-orange-500"><a href={{route('story.edit', $each)}}>Edit</a></td>
                    <td class="whitespace-nowrap  px-6 py-4 text-red-700"><a href={{route('story.destroy', $each->id)}}>Delete</a></td>
                    <td class="whitespace-nowrap  px-6 py-4 text-blue-700"><a href={{route('story.detail', $each->id)}}>Detail</a></td>
                </tr>
            @endforeach
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')

<script>
   
    @if (Session::has('message'))
    toastr.success("{{ Session::get('message') }}") 
    @endif
</script>
@endpush