<script setup lang="ts">

import { type BreadcrumbItem } from '@/types';
import {Head, Link} from '@inertiajs/vue3';
import AppLayout from "@/layouts/AppLayout.vue";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Posts',
        href: '/posts',
    },
];

const props = defineProps({
    posts: Array
});

</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">

            <!-- New post -->
            <Link
                :href="route('posts.create')"
                class="inline-block rounded border p-2 bg-white text-black"
            >
                Add new post
            </Link>

            <!-- Post list -->
            <ul>
                <li v-for="post in posts.data" :key="post.id" class="p-2">
                    <Link :href="`/posts/${post.id}`">{{ post.title }} -- {{ new Date(post.created_at).toLocaleString() }}</Link>
                </li>
            </ul>

            <!-- Pagination -->
            <div class="mt-4 space-x-2">
                <Link
                    v-for="link in posts.links"
                    :key="link.label"
                    :href="link.url"
                    v-html="link.label"
                    :class="{
          'text-gray-500': !link.url,
          'font-bold underline': link.active
        }"
                />
            </div>
        </div>
    </AppLayout>
</template>
