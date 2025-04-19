<script setup lang="ts">

import { type BreadcrumbItem } from '@/types';
import {Head, Link, useForm} from '@inertiajs/vue3';
import PlaceholderPattern from "@/components/PlaceholderPattern.vue";
import AppLayout from "@/layouts/AppLayout.vue";
import InputError from "@/components/InputError.vue";
import {Label} from "@/components/ui/label";
import {Input} from "@/components/ui/input";
import {Button} from "@/components/ui/button";
import {LoaderCircle} from "lucide-vue-next";

const form = useForm({
    title: '',
    content: '',
});

const submit = () => {
    form.post(route('posts.store'), {
        onFinish: () => {
            form.reset();
        },
    });
};

</script>

<template>
    <Head title="Create new post" />

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

    <h1 class="text-[24px]">Add new post</h1>
    <div
        class="rounded-lg p-6 max-w-2xl"
    >
        <form @submit.prevent="submit">
            <div class="space-y-6">
                <div class="grid gap-2">
                    <Label htmlFor="title">Title</Label>
                    <Input
                        id="title"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.title"
                        required
                        autofocus
                    />

                    <InputError :message="form.errors.title" />
                </div>

                <div class="grid gap-2">
                    <Label htmlFor="content">Content</Label>
                    <textarea
                        id="content"
                        type="text"
                        class="mt-1 block w-full border-1 h-24 rounded"
                        v-model="form.content"
                    />

                    <InputError :message="form.errors.content" />
                </div>

                <div class="flex items-center">
                    <Button class="w-full" :disabled="form.processing">
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        Create
                    </Button>
                </div>
            </div>
        </form>
    </div>
</template>
