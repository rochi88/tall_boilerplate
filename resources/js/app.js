import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


// Adding turbo
require('livewire-turbolinks')

var Turbo = require("@hotwired/turbo")

Turbo.start()

// Adding sweetalart2
import Swal from 'sweetalert2';

window.Swal = Swal;