import './bootstrap';

import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import collapse from '@alpinejs/collapse';
import mask from '@alpinejs/mask';

window.Alpine = Alpine;
Alpine.plugin(mask)
Alpine.plugin(collapse);
Alpine.plugin(persist);
Alpine.start();


// Adding turbo
import 'livewire-turbolinks';
import '@hotwired/turbo';
// import * as Turbo from "@hotwired/turbo";

