<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('reset:monthly-status')->monthlyOn(1, '00:00');
