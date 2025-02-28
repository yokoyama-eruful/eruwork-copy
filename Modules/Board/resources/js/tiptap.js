import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline'
import Link from '@tiptap/extension-link';
import CodeBlock from '@tiptap/extension-code-block';
import BulletList from '@tiptap/extension-bullet-list';
import ListItem from '@tiptap/extension-list-item';
import OrderedList from '@tiptap/extension-ordered-list';

document.addEventListener('alpine:init', () => {
    Alpine.data('editor', (content) => {
        let editor;

        return {
            updatedAt: Date.now(),
            init() {
                const _this = this;

                editor = new Editor({
                    element: this.$refs.element,
                    extensions: [StarterKit, Underline, Link],
                    content: content,
                    editable: this.isEditable,
                    onCreate({ editor }) {
                        _this.updatedAt = Date.now();
                    },
                    onUpdate({ editor }) {
                        _this.updatedAt = Date.now();
                    },
                    onSelectionUpdate({ editor }) {
                        _this.updatedAt = Date.now();
                    },

                    editorProps: {
                        handleKeyDown: (view, event) => {
                            if (event.key === 'Enter') {
                                // 改行を挿入する
                                event.preventDefault(); // デフォルトの挙動を防ぐ
                                editor.chain().focus().insertContent('<br>').run(); // 改行挿入
                                return true;
                            }
                            return false;
                        },
                    }
                });

                editor.on('focus', () => {
                    document.querySelectorAll('[contenteditable]').forEach(element => {
                        element.style.outline = 'none';
                    });
                });
            },
            isLoaded() {
                return editor;
            },
            isActive(type, opts = {}) {
                return editor.isActive(type, opts);
            },
            toggleBold() {
                this.updatedAt = Date.now();
                editor.chain().focus().toggleBold().run();
            },
            toggleItalic() {
                this.updatedAt = Date.now();
                editor.chain().toggleItalic().focus().run();
            },
            toggleStrike() {
                this.updatedAt = Date.now();
                editor.chain().toggleStrike().focus().run();
            },
            toggleUnderline() {
                this.updatedAt = Date.now();
                editor.chain().toggleUnderline().focus().run();
            },
            toggleLink() {
                const url = prompt('リンクのURLを入力してください:');
                if (url) {
                    editor.chain().focus().toggleLink({ href: url }).run();
                } else {
                    editor.chain().focus().toggleLink().run();
                }
            },
            toggleOrderedList() {
                this.updatedAt = Date.now();
                editor.chain().focus().toggleOrderedList().run();
            },
            toggleBulletList() {
                this.updatedAt = Date.now();
                editor.chain().focus().toggleBulletList().run();
            },
            toggleCodeBlock() {
                this.updatedAt = Date.now();
                editor.chain().focus().toggleCodeBlock().run();
            },
            submitFormPost() {
                this.$refs.actionInput.value = 'post';
                this.$refs.contents.value = editor.getHTML();
                this.$el.closest('form').submit();
            },
            submitFormSave() {
                this.$refs.actionInput.value = 'save'; 
                this.$refs.contents.value = editor.getHTML();
                this.$el.closest('form').submit();
            }
        }
    });
});
