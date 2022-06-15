<template>
    <div
        class="permissions-w-full permissions-grid 2xl:permissions-grid-cols-5 xl:permissions-grid-cols-4 lg:permissions-grid-cols-3 permissions-grid-cols-2 md:permissions-py-3 permissions-px-3 text-sm">
        <template v-if="field.withGroups">
            <div v-for="(permissions, group) in field.options" :key="group"
                 class="permissions-mb-4 permissions-flex-auto">
                <h3 class="permissions-font-bold permissions-capitalize text-sm">{{ __(group) }}</h3>
                <div v-for="(permission, option) in permissions" :key="option"
                     class="permissions-flex-auto permissions-py-0.5">
                        <span
                            :class="field.value.includes(permission.option) ? 'permissions-bg-green-400' : 'permissions-bg-red-500'"
                            class="permissions-inline-block permissions-rounded-full permissions-w-2 permissions-h-2 permissions-mr-2"
                        />
                    <span class="permissions-capitalize">{{ permission.label }}</span>
                </div>
            </div>
        </template>
        <template v-else>
            <div
                v-for="(label, option) in field.options"
                :key="option"
                class="permissions-flex-auto"
            >
                    <span
                        :class="field.value.includes(option) ? 'permissions-bg-green-400' : 'permissions-bg-red-500'"
                        class="permissions-inline-block permissions-rounded-full permissions-w-2 permissions-h-2 permissions-mr-1"
                    />
                <span>{{ label }}</span>
            </div>
        </template>
    </div>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
}
</script>
