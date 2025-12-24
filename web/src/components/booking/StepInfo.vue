<template>
  <div>
    <div class="space-y-3">
      <div>
        <label class="block text-sm font-semibold text-neutral-900 mb-1.5">
          Nom complet <span class="text-error-600">*</span>
        </label>
        <input
          :value="clientName"
          @input="$emit('update:clientName', $event.target.value)"
          type="text"
          class="w-full px-3.5 py-2.5 bg-white border-2 border-neutral-200 rounded-lg text-sm text-neutral-900 placeholder-neutral-400 focus:outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-100 transition-all shadow-sm focus:shadow-md"
          placeholder="Jean Dupont"
          autocomplete="name"
        />
      </div>

      <div>
        <label class="block text-sm font-semibold text-neutral-900 mb-1.5">
          Adresse email <span class="text-error-600">*</span>
        </label>
        <input
          :value="clientEmail"
          @input="$emit('update:clientEmail', $event.target.value)"
          type="email"
          class="w-full px-3.5 py-2.5 bg-white border-2 border-neutral-200 rounded-lg text-sm text-neutral-900 placeholder-neutral-400 focus:outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-100 transition-all shadow-sm focus:shadow-md"
          placeholder="vous@exemple.com"
          autocomplete="email"
        />
      </div>

      <div>
        <label class="block text-sm font-semibold text-neutral-900 mb-1.5">
          Notes <span class="text-neutral-600 text-sm font-normal">(optionnel)</span>
        </label>
        <textarea
          :value="notes"
          @input="$emit('update:notes', $event.target.value)"
          class="w-full px-3.5 py-2.5 bg-white border-2 border-neutral-200 rounded-lg text-sm text-neutral-900 placeholder-neutral-400 focus:outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-100 transition-all resize-none shadow-sm focus:shadow-md"
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
