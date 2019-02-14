<template>
    <panel-item :field="field">
        <p slot="value" class="text-90 flex">
            <span class="w-full max-col-2" v-if="field.withGroups">
                <div v-for="(permissions, group) in field.options" :key="group" class="mb-4">
                    <h3 class="my-2">{{ __(group) }}</h3>
                    <div v-for="(permission, option) in permissions" :key="option" class="flex-auto">
                        <span
                        class="inline-block rounded-full w-2 h-2 mr-1"
                        :class="optionClass(permission.option)"
                        />
                        <span>{{ permission.label }}</span>
                    </div>
                </div>
            </span>
            <span class="w-full max-col-2" v-else>
                <div
                v-for="(label, option) in field.options"
                :key="option"
                class="flex-auto"
                >
                <span
                class="inline-block rounded-full w-2 h-2 mr-1"
                :class="optionClass(option)"
                />
                <span>{{ label }}</span>
            </div>
        </span>
    </p>
</panel-item>
</template>

<script>
    export default {
        props: ['resource', 'resourceName', 'resourceId', 'field'],
        methods: {
            optionClass(option) {
                return {
                    'bg-success': this.field.value ? this.field.value.includes(option) : false,
                    'bg-danger': this.field.value ? !this.field.value.includes(option) : true,
                }
            },
        },
    }
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