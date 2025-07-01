import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.store('dialogs', {
  dialogs: {
    
  },
  register(id, dialog) {
    this.dialogs[id] = dialog;
  },
  open(id) {
    console.log('olix')
    // this.dialogs[id].open();
  },
});

document.addEventListener('alpine:init', () => {
  // Alpine.bind('open-dialog', (id) => {
  //   console.log('holaaa')
  //   Alpine.store('dialogs').open(id);
  // });

  Alpine.bind('SomeButton', () => ({
    type: 'button',

    '@click'() {
      console.log('asdasd')
      // this.$store.dialogs.open('basic-dialog')
      this.$dispatch('open-modal', 'basic-dialog')
    },

    ':disabled'() {
      return this.shouldDisable
    },
  }))
});

// Alpine.start();
