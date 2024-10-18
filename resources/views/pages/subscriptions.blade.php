<?php
 
use function Laravel\Folio\name;
use function Livewire\Volt\{state, computed};
// use Glhd\Bits\Snowflake;

use App\Models\Plan;

name('subscriptions');

$subscriptions = computed(function () {
   return auth()->user()->activeSubscriptions()->with('plan')->get();
});

$plans = computed(function () {
  $user = auth()->user();

  $subscribedPlanIds = $user->activeSubscriptions()->pluck('plan_id')->toArray();

  return Plan::whereNotIn('id', $subscribedPlanIds)->get();
});


$subscribe = function ($planId) {
  $plan = Plan::find($planId);
  auth()->user()->subscribe($plan);
};

$cancel = function ($subscriptionId) {
  $subscription = auth()->user()->subscriptions()->findOrFail($subscriptionId);
  $subscription->cancel();
};
?>

<x-app-layout>
  @volt('customer-trial-page')
  <div class="container mx-auto mt-12 space-y-16">
      <h1 class="text-4xl font-bold text-gray-600">Your subscriptions</h1>
      
      <div class="max-w-lg space-y-3">
        @if(! $this->subscriptions->isEmpty())
          <h2 class="text-xl font-medium text-gray-600">Active Subscriptions</h2>
          <ul class="space-y-2">
            @foreach ($this->subscriptions as $subscription)
            <li class="flex items-center justify-between px-3 py-2 bg-white rounded shadow">
              <p class="text-gray-600">{{ $subscription->plan->name }}</p>
              <x-secondary-button wire:click="cancel('{{ $subscription->id }}')">Cancel</x-secondary-button>  
            </li> 
            @endforeach
            @else
            <p class="text-gray-600">You have no subscriptions</p>
          @endif
        </ul>
      </div>

      {{-- Plans --}}
      <div class="space-y-3">
        <p class="text-xl font-medium text-gray-600">Available Plans</p>
        @if ($this->plans->isEmpty())
          <p class="text-gray-600">No plans available</p>

          @else  
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
            @foreach ($this->plans as $plan)
            <div class="p-4 space-y-3 bg-white rounded shadow">
              <p class="text-lg font-medium text-gray-600">{{ $plan->name }}</p>
              <x-secondary-button  wire:click="subscribe('{{ $plan->id }}')">Subscribe</x-secondary-button>
            </div>
            @endforeach
          </div>
        </div>
        @endif
    </div>
  @endvolt
</x-app-layout>