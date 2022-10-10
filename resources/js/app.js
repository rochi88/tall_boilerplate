import './bootstrap';

import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import collapse from '@alpinejs/collapse';
import mask from '@alpinejs/mask';

Alpine.plugin(mask)
Alpine.plugin(collapse);
Alpine.plugin(persist);

window.Alpine = Alpine;

Alpine.start();


// Adding turbo
import 'livewire-turbolinks';
import '@hotwired/turbo';
// import * as Turbo from "@hotwired/turbo";

