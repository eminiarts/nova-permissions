<template>
    <div class="w-full permissions-overflow-auto permissions-h-80">
        <div v-for="(permissions, group) in field.options"
             :key="group" class="permissions-flex permissions-border">

            <h3 class="permissions-capitalize permissions-mr-1 permissions-text-xs permissions-w-1/12 permissions-mt-1.5 permissions-pl-1">
                {{ __(group) }}</h3>
            <div
                v-for="permission in permissions"
                :key="permission.option"
                class="permissions-flex-auto permissions-py-0.5"
            >
            <span
                :class="(field.value ? field.value.includes(permission.option) : false) ? 'permissions-bg-green-400' : 'permissions-bg-red-500'"
                class="permissions-inline-block permissions-rounded-full permissions-w-2 permissions-h-2 permissions-mr-1 permissions-text-xs"
            /><span class="permissions--mt-1.5">{{ permission.label }}</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
}
</script>
