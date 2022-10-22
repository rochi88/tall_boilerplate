import './bootstrap';

import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';

window.Alpine = Alpine;
Alpine.plugin(persist);
Alpine.start();


// Adding turbo
import 'livewire-turbolinks';
// import '@hotwired/turbo';
import * as Turbo from "@hotwired/turbo";

