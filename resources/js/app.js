import './bootstrap';

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import collapse from '@alpinejs/collapse';

Alpine.plugin(intersect);
Alpine.plugin(collapse);

import './landing';

window.Alpine = Alpine;
Alpine.start();

import ApexCharts from 'apexcharts';
window.ApexCharts = ApexCharts;
