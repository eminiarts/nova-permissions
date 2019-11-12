<template>
    <panel-item :field="field">
        <p slot="value" class="text-90 flex">
            <span class="flex flex-wrap" v-if="field.withGroups">
                <div
                    v-for="(permissions, group) in field.options"
                    :key="group"
                    class="w-1/2 mb-2"
                >
                    <h3 class="my-2 capitalize">{{ fixNaming(group) }}</h3>
                    <div
                        v-for="(permission, option) in permissions"
                        :key="option"
                        class="flex-auto"
                    >
                        <span
                            class="inline-block rounded-full w-2 h-2 mr-1"
                            :class="optionClass(permission.option)"
                        />
                        <span>{{ fixNaming(permission.label) }}</span>
                    </div>
                </div>
            </span>
            <span class="flex flex-wrap" v-else>
                <div
                v-for="(label, option) in field.options"
                :key="option"
                class="w-1/2 mb-2"
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

            groupName: (group) => {
                return group.replace('_', ' ')
            },

            fixNaming: (name) => {
                if(name.includes("_") === true) {
                    name = name.replace('_', ' ')
                }

                if(name.includes("-") === true) {
                    name = name.replace('-', ' ')
                }
                return name
            }
        }
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
