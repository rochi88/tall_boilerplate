import './bootstrap';

import.meta.glob(["../images/**"]);

import {
  Livewire,
  Alpine,
} from "../../vendor/livewire/livewire/dist/livewire.esm";

import "./../../vendor/power-components/livewire-powergrid/dist/powergrid";
import "./../../vendor/power-components/livewire-powergrid/dist/tailwind.css";

Livewire.start();
