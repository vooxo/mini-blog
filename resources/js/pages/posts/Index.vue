<script setup lang="ts">

import { type BreadcrumbItem } from '@/types';
import {Head, Link} from '@inertiajs/vue3';

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

    <div class="flex flex-col items-left bg-[#FDFDFC] p-6 text-[#1b1b18] dark:bg-[#0a0a0a] lg:justify-center lg:p-8">
        <header class="not-has-[nav]:hidden mb-6 w-full max-w-[335px] text-sm lg:max-w-4xl">
            <nav class="flex items-left gap-4">
                <Link
                    :href="route('posts.index')"
                    class="inline-block rounded-sm border px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                >
                    Blog
                </Link>
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >
                    Dashboard
                </Link>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="inline-block rounded-sm border px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                    >
                        Log in
                    </Link>
                    <Link
                        :href="route('register')"
                        class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                    >
                        Register
                    </Link>
                </template>
            </nav>
        </header>
    </div>

    <div class="p-4">

        <h1 class="text-2xl m-4">Blog</h1>

        <!-- New post -->
        <div v-if="$page.props.auth.user">
            <Link
                :href="route('posts.create')"
                class="inline-block rounded border p-2 m-2 bg-white text-black"
            >
                Add new post
            </Link>
        </div>

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
</template>
