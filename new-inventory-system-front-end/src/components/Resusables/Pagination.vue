<template>
    <div class="flex justify-end">
      <button
        class="btn btn-primary mr-2"
        :disabled="!meta.links[0].url"
        @click="paginate(meta.current_page - 1)"
      >
        Prev
      </button>
      <button
      class="btn btn-primary mr-2"
      :disabled="!meta.links[0].url"
      @click="paginate(meta.current_page - 1)"
    >
      Prev
    </button>
    </div>
    </template>
  