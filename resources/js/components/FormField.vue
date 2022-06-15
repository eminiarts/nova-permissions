<template>
    <div class="permissions-w-full md:permissions-py-3 permissions-px-7 text-sm">
      <div class="permissions-w-full permissions-mb-4 space-x-2">
        <span class="shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900 cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900" @click="checkAll()">{{ __('Select all')}}</span>
        <span class="shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900 cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900" @click="uncheckAll()">{{ __('Do not select any') }}</span>
      </div>
      <div class="permissions-w-full permissions-grid 2xl:permissions-grid-cols-5 xl:permissions-grid-cols-4 lg:permissions-grid-cols-3 permissions-grid-cols-2 md:permissions-py-3 permissions-px-1" v-if="field.withGroups">
        <div v-for="(permissions, group) in field.options" :key="group" class="mb-4">
            <h3 class="permissions-font-bold permissions-capitalize permissions-mb-1 text-sm">{{ __(group) }}</h3>
          <div
            v-for="(permission, option) in permissions"
            :key="permission.option"
            class="permissions-flex-auto permissions-py-0.5"
          >
            <checkbox
              :value="permission.option"
              :checked="isChecked(permission.option)"
              @input="toggleOption(permission.option)"
            />
            <label
              :for="field.name"
              v-text="permission.label"
              @click="toggleOption(permission.option)"
              class="permissions-pl-2 permissions-w-full permissions-capitalize"
            ></label>
          </div>
        </div>
      </div>
      <div class="permissions-w-full permissions-grid 2xl:permissions-grid-cols-5 xl:permissions-grid-cols-4 lg:permissions-grid-cols-3 permissions-grid-cols-2 md:permissions-py-3 permissions-px-1" v-else>
        <div v-for="(label, option) in field.options" :key="option" class="flex mb-2">
          <checkbox
            :value="option"
            :checked="isChecked(option)"
            @input="toggleOption(option)"
          />
          <label :for="field.name" v-text="label" @click="toggleOption(option)" class="permissions-pl-2 permissions-w-full permissions-capitalize"></label>
        </div>
      </div>
      <p v-if="hasError" class="permissions-my-2 permissions-text-red-500">{{ firstError }}</p>
    </div>
</template>

<script>
import { DependentFormField, HandlesValidationErrors } from 'laravel-nova'
export default {
  mixins: [DependentFormField, HandlesValidationErrors],
  props: ["resourceName", "resourceId", "field"],
  methods: {
    checkAll() {
      // With Groups
      if (this.field.withGroups) {
        let permissions = _.flatMap(this.field.options);
        for (var i = 0; i < permissions.length; i++) {
          this.check(permissions[i].option);
        }
      }
      // Todo: Without Groups
    },
    uncheckAll() {
      // With Groups
      if (this.field.withGroups) {
        let permissions = _.flatMap(this.field.options);
        for (var i = 0; i < permissions.length; i++) {
          this.uncheck(permissions[i].option);
        }
      }
      // Todo: Without Groups
    },
    isChecked(option) {
      return this.value ? this.value.includes(option) : false;
    },
    check(option) {
      if (!this.isChecked(option)) {
        this.value.push(option);
      }
    },
    uncheck(option) {
      if (this.isChecked(option)) {
        this.value = this.value.filter(item => item != option);
      }
    },
    toggleOption(option) {
      if (this.isChecked(option)) {
        return this.uncheck(option);
      }
      this.check(option);
    },
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.value = this.field.value || [];
    },
    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      console.log(this.value);
      formData.append(this.field.attribute, this.value || []);
    },
    /**
     * Update the field's internal value.
     */
    handleChange(value) {
      this.value = value;
    }
  }
};
</script>

<style>
.max-col-3 {
  -moz-column-count: 3;
  -webkit-column-count: 3;
  column-count: 3;
  white-space: nowrap;
}
.max-col-2 {
  -moz-column-count: 2;
  -webkit-column-count: 2;
  column-count: 2;
  white-space: nowrap;
}
</style>
