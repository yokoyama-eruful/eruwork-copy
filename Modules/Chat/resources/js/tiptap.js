import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';
import Link from '@tiptap/extension-link';
import HardBreak from '@tiptap/extension-hard-break'

window.setupEditor = function(content) {
    let editor

    return {
        content: content,

        init(element) {
            editor = new Editor({
                element: element,
                content: this.content,
                extensions: [
                    StarterKit,
                    Underline,
                    Link,
                    HardBreak.extend({
                        addKeyboardShortcuts () {
                          return {
                            Enter: () => editor.commands.setHardBreak()
                          }
                        }
                      }),
                ],
                onCreate({ editor }) {
                    this.content = editor.getHTML();
                },
                onUpdate: ({ editor }) => {
                    this.content = editor.getHTML();
                },
                onSelectionUpdate({ editor }) {
                    this.content = editor.getHTML();
                },
            });

            editor.on('focus', () => {
                document.querySelectorAll('[contenteditable]').forEach(element => {
                    element.style.outline = 'none';
                });
            });
        },
        isActive(type) {
            return editor.isActive(type);
        },
        toggleBold() {
            editor.chain().focus().toggleBold().run();
        },
        toggleItalic() {
            editor.chain().toggleItalic().focus().run();
        },
        toggleStrike() {
            editor.chain().toggleStrike().focus().run();
        },
        toggleUnderline() {
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
            editor.chain().focus().toggleOrderedList().run();
        },
        toggleBulletList() {
            editor.chain().focus().toggleBulletList().run();
        },
    }
}
