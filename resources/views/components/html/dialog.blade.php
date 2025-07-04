@props(['id' => 'basic-dialog', 'title' => '', 'show' => false])

<div x-data="{
    isOpen: false,
    title: '{{ $title }}',
    body: '',

    init() {
        // Listen for the open-modal event
        this.$watch('isOpen', value => {
            if (value) {
                document.body.classList.add('overflow-y-hidden');
                this.$refs.modal.classList.add('show')
            } else {
                document.body.classList.remove('overflow-y-hidden');
                this.$refs.modal.classList.remove('show')
            }
        })
    },
    
    open(id) {
        if (id === '{{ $id }}') {
            this.isOpen = true
        }
    },
    
    close() {
        this.isOpen = false
    }
}" 
x-init="init" 
x-show="isOpen" 
id="{{ $id }}" 
data-tw-backdrop=""
x-on:open-modal.window="open($event.detail)"
x-on:close-modal.window="close"
x-on:click.outside.debounce="close" 
x-on:keydown.escape.window="close"
x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
x-on:keydown.shift.tab.prevent="prevFocusable().focus()" 
x-ref="modal"
class="modal group bg-black/60 transition-[visibility,opacity] w-screen h-screen fixed left-0 top-0 [&amp;:not(.show)]:duration-[0s,0.2s] [&amp;:not(.show)]:delay-[0.2s,0s] [&amp;:not(.show)]:invisible [&amp;:not(.show)]:opacity-0 [&amp;.show]:visible [&amp;.show]:opacity-100 [&amp;.show]:duration-[0s,0.4s] overflow-y-auto {{ $show ? 'show' : '' }}"
aria-hidden="false" 
style="margin-top: 0px; margin-left: 0px; padding-left: 0px; z-index: 10000;">
    <div
        class="box relative before:absolute before:inset-0 before:mx-3 before:-mb-3 before:border before:border-foreground/10 before:z-[-1] after:absolute after:inset-0 after:border after:border-foreground/10 after:bg-background after:shadow-[0px_3px_5px_#0000000b] after:z-[-1] after:backdrop-blur-md before:bg-background/60 dark:before:shadow-background before:shadow-foreground/60 z-50 mx-auto -mt-16 p-6 transition-[margin-top,transform] duration-[0.4s,0.3s] before:rounded-3xl before:shadow-2xl after:rounded-3xl group-[.show]:mt-16 group-[.modal-static]:scale-[1.05] sm:max-w-lg">
        <div class="flex flex-col items-center gap-3 py-2 text-center">
            <h2 class="text-lg font-medium" x-text="title"></h2>
            {{ $slot }}

            <button
                class="cursor-pointer inline-flex border items-center justify-center gap-2 whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-(--color)/20 border-(--color)/60 text-(--color) hover:bg-(--color)/5 [--color:var(--color-primary)] h-10 px-4 py-2 mt-2 w-40"
                data-tw-dismiss="modal" 
                type="button" 
                x-on:click="close">
                Cerrar
            </button>
        </div>
    </div>
</div>
