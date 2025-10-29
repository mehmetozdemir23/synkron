<template>
  <div class="space-y-4 sm:space-y-6">
    <div>
      <h2 class="text-xl sm:text-2xl font-normal text-neutral-950 mb-1 sm:mb-2">Vos informations</h2>
      <p class="text-xs sm:text-sm text-neutral-700">Complétez vos coordonnées pour finaliser la réservation</p>
    </div>

    <div class="space-y-3 sm:space-y-4">
      <div>
        <label class="block text-xs sm:text-sm font-medium text-neutral-800 mb-1.5 sm:mb-2">
          Nom complet <span class="text-error-600">*</span>
        </label>
        <input
          :value="clientName"
          @input="$emit('update:clientName', $event.target.value)"
          type="text"
          class="w-full px-4 py-3 bg-neutral-300 border-2 border-neutral-400 rounded-lg text-xs sm:text-sm text-neutral-950 placeholder-neutral-600 focus:outline-none focus:border-brand-500 transition-all min-h-[44px]"
          placeholder="Jean Dupont"
          autocomplete="name"
        />
      </div>

      <div>
        <label class="block text-xs sm:text-sm font-medium text-neutral-800 mb-1.5 sm:mb-2">
          Adresse email <span class="text-error-600">*</span>
        </label>
        <input
          :value="clientEmail"
          @input="$emit('update:clientEmail', $event.target.value)"
          type="email"
          class="w-full px-4 py-3 bg-neutral-300 border-2 border-neutral-400 rounded-lg text-xs sm:text-sm text-neutral-950 placeholder-neutral-600 focus:outline-none focus:border-brand-500 transition-all min-h-[44px]"
          placeholder="vous@exemple.com"
          autocomplete="email"
        />
      </div>

      <div>
        <label class="block text-xs sm:text-sm font-medium text-neutral-800 mb-1.5 sm:mb-2">
          Notes <span class="text-neutral-600 font-normal">(optionnel)</span>
        </label>
        <textarea
          :value="notes"
          @input="$emit('update:notes', $event.target.value)"
          class="w-full px-4 py-3 bg-neutral-300 border-2 border-neutral-400 rounded-lg text-xs sm:text-sm text-neutral-950 placeholder-neutral-600 focus:outline-none focus:border-brand-500 transition-all resize-none"
          placeholder="Des informations supplémentaires..."
          rows="3"
        ></textarea>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  clientName: {
    type: String,
    required: true,
  },
  clientEmail: {
    type: String,
    required: true,
  },
  notes: {
    type: String,
    default: "",
  },
});

defineEmits(["update:clientName", "update:clientEmail", "update:notes"]);
</script>
