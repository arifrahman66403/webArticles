@props(['active' => false])

<a {{ $attributes }} class="{{ $active ? 'whitespace-nowrap border-b-2 border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700'}}
block px-4 py-2 rounded-md font-bold"
class="px-3 py-2 text-sm font-medium" aria-current="{{ $active ? 'page' : false }}">{{$slot}}</a>
