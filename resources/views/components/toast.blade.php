@props(['id' => 'toast-container'])

<div id="{{ $id }}" class="toast-container"></div>

<style>
/* Sobrescribir estilos por defecto de Toastify */
.toastify {
    background: inherit !important;
    box-shadow: none !important;
}

.toastify-center {
    background: inherit !important;
}

.toastify-top {
    background: inherit !important;
}

/* Posicionar el botón de cerrar correctamente */
.toast-close {
    position: absolute !important;
    top: 1rem !important;
    right: 1.5rem !important;
    background: none !important;
    border: none !important;
    font-size: 16px !important;
    cursor: pointer !important;
    color: #666 !important;
    padding: 4px !important;
    line-height: 1 !important;
    z-index: 10 !important;
}

.toast-close:hover {
    color: #333 !important;
    background: rgba(0,0,0,0.1) !important;
    border-radius: 50% !important;
}

/* Asegurar que nuestro toast personalizado tenga el estilo correcto */
.toast .box {
    background: var(--color-background, white);
    color: var(--color-foreground, black);
    position: relative !important;
}
</style>

<script>
    // Toast handler using Toastify y plantilla HTML
    window.ToastHandler = {
        createToastElement(title, message) {
            const toastDiv = document.createElement('div');
            toastDiv.className = 'toast';
            toastDiv.innerHTML = `
                <div class="box relative p-6 before:absolute before:inset-0 before:mx-3 before:-mb-3 before:border before:border-foreground/10 before:bg-background/30 before:shadow-[0px_3px_5px_#0000000b] before:z-[-1] before:rounded-xl after:absolute after:inset-0 after:border after:border-foreground/10 after:bg-background after:shadow-[0px_3px_5px_#0000000b] after:rounded-xl after:z-[-1] after:backdrop-blur-md">
                    <div class="flex">
                        <div class="grid gap-1">
                            ${title ? `<div class="font-semibold">${title}</div>` : ''}
                            <div class="opacity-70">${message}</div>
                        </div>
                    </div>
                </div>
            `;
            return toastDiv;
        },
        show(message, options = {}) {
            const title = options.title || '';
            const defaultOptions = {
                node: this.createToastElement(title, message),
                duration: 3000,
                close: true,
                gravity: "top",
                position: "center",
                stopOnFocus: true,
        
            };
            
            const finalOptions = {
                ...defaultOptions,
                ...options
            };
            
            return Toastify(finalOptions).showToast();
        },
        success(message, options = {}) {
            return this.show(message, {
                title: 'Éxito',
                ...options,
                type: 'success'
            });
        },
        error(message, options = {}) {
            return this.show(message, {
                title: 'Error!',
                ...options,
                type: 'error'
            });
        },
        warning(message, options = {}) {
            return this.show(message, {
                title: 'Advertencia!',
                ...options,
                type: 'warning'
            });
        },
        info(message, options = {}) {
            return this.show(message, {
                title: 'Información!',
                ...options,
                type: 'info'
            });
        }
    };

    // Alpine.js store for toast management
    document.addEventListener('alpine:init', () => {
        Alpine.store('toast', {
            show(message, options = {}) {
                return ToastHandler.show(message, options);
            },

            success(message, options = {}) {
                return ToastHandler.success(message, options);
            },

            error(message, options = {}) {
                return ToastHandler.error(message, options);
            },

            warning(message, options = {}) {
                return ToastHandler.warning(message, options);
            },

            info(message, options = {}) {
                return ToastHandler.info(message, options);
            }
        });
    });
</script>
