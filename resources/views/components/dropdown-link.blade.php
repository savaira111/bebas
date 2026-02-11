<a {{ $attributes->merge([
    'class' => 'block w-full px-4 py-2 text-start text-sm leading-5 
               text-white font-semibold
               hover:bg-[#1a1f3b] 
               focus:outline-none focus:bg-[#1a1f3b] 
               active:bg-[#1a1f3b]
               transition duration-150 ease-in-out'
]) }}>
    {{ $slot }}
</a>    