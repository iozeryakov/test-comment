<template>
  <div class="comment">
    <div class="title_input">
      <span class="name">{{ comment.name }}</span>
      <button
        class="delete"
        @click="$emit('deleteComment', comment.id)"
      ></button>
    </div>
    <span class="text" v-html="formattedText()"></span>
    <span class="date">{{
      new Date(comment.created_at).toLocaleDateString("RU", {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "numeric",
        minute: "numeric",
      })
    }}</span>
  </div>
</template>
<script>
export default {
  props: {
    comment: {
      type: Object,
      required: true,
    },
  },
  methods: {
    formattedText() {
      return this.comment.comment.replace(/\n/g, "<br>");
    },
  },
};
</script>
<style scoped>
.name {
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
  margin: 5px 0;
  font-size: 18px;
  font-weight: 600;
  margin-right: 10px;
}
.comment {
  display: flex;
  flex-direction: column;
  overflow: hidden;
}
.comment:not(:last-child) {
  margin-bottom: 5px;
  border-bottom: 1px solid gray;
}
.date {
  margin: 5px 0;
  color: rgba(0, 0, 0, 0.5);
  font-size: 14px;
  align-self: flex-end;
}
.text {
  word-wrap: break-word;
  color: rgba(0, 0, 0, 0.8);
}
.delete {
  outline: none;
  border: none;
  background: black;
  cursor: pointer;
  min-width: 20px;
  height: 20px;
  position: relative;
}
.delete::before,
.delete::after {
  content: "";
  position: absolute;
  top: 50%;
  left: 50%;
  width: 15px;
  height: 2px;
  background-color: white;
  transform: translate(-50%, -50%) rotate(45deg);
}
.delete::after {
  transform: translate(-50%, -50%) rotate(-45deg);
}
.delete:hover::after,
.delete:hover::before {
  width: 10px;
}
</style>
