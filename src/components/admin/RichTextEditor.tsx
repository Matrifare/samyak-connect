import { useEffect, useRef } from "react";
import { useEditor, EditorContent } from "@tiptap/react";
import StarterKit from "@tiptap/starter-kit";
import Underline from "@tiptap/extension-underline";
import TextAlign from "@tiptap/extension-text-align";
import { Button } from "@/components/ui/button";
import { Toggle } from "@/components/ui/toggle";
import { Separator } from "@/components/ui/separator";
import {
  Bold,
  Italic,
  Underline as UnderlineIcon,
  Strikethrough,
  List,
  ListOrdered,
  AlignLeft,
  AlignCenter,
  AlignRight,
  Heading1,
  Heading2,
  Heading3,
  Quote,
  Undo,
  Redo,
  RemoveFormatting,
} from "lucide-react";

interface RichTextEditorProps {
  content: string;
  onChange: (content: string) => void;
  placeholder?: string;
}

const RichTextEditor = ({ content, onChange, placeholder }: RichTextEditorProps) => {
  // TipTap only uses `content` on first mount; keep it in sync when editing an existing post.
  const lastContentRef = useRef<string>(content || "");

  const editor = useEditor({
    extensions: [
      StarterKit.configure({
        heading: {
          levels: [1, 2, 3],
        },
      }),
      Underline,
      TextAlign.configure({
        types: ["heading", "paragraph"],
      }),
    ],
    content: content || "",
    onUpdate: ({ editor }) => {
      const html = editor.getHTML();
      lastContentRef.current = html;
      onChange(html);
    },
    editorProps: {
      attributes: {
        class:
          "min-h-[200px] max-h-[400px] overflow-y-auto p-4 focus:outline-none text-white",
      },
    },
  });

  useEffect(() => {
    if (!editor) return;
    const next = content || "";

    // Don’t fight the user while typing.
    if (editor.isFocused) return;
    if (lastContentRef.current === next) return;

    lastContentRef.current = next;
    // Keep TipTap in sync without triggering onUpdate loops.
    editor.commands.setContent(next, { emitUpdate: false });
  }, [content, editor]);

  if (!editor) {
    return null;
  }

  return (
    <div className="border border-slate-600 rounded-lg overflow-hidden bg-slate-800">
      {/* Toolbar */}
      <div className="flex flex-wrap items-center gap-1 p-2 border-b border-slate-600 bg-slate-700">
        {/* Undo/Redo */}
        <Button
          type="button"
          variant="ghost"
          size="sm"
          onClick={() => editor.chain().focus().undo().run()}
          disabled={!editor.can().undo()}
          className="h-8 w-8 p-0 text-slate-300 hover:text-white hover:bg-slate-600 disabled:text-slate-500"
        >
          <Undo className="h-4 w-4" />
        </Button>
        <Button
          type="button"
          variant="ghost"
          size="sm"
          onClick={() => editor.chain().focus().redo().run()}
          disabled={!editor.can().redo()}
          className="h-8 w-8 p-0 text-slate-300 hover:text-white hover:bg-slate-600 disabled:text-slate-500"
        >
          <Redo className="h-4 w-4" />
        </Button>

        <Separator orientation="vertical" className="h-6 mx-1 bg-slate-500" />

        {/* Headings */}
        <Toggle
          size="sm"
          pressed={editor.isActive("heading", { level: 1 })}
          onPressedChange={() =>
            editor.chain().focus().toggleHeading({ level: 1 }).run()
          }
          className="h-8 w-8 p-0 text-slate-300 hover:text-white hover:bg-slate-600 data-[state=on]:bg-primary data-[state=on]:text-white"
        >
          <Heading1 className="h-4 w-4" />
        </Toggle>
        <Toggle
          size="sm"
          pressed={editor.isActive("heading", { level: 2 })}
          onPressedChange={() =>
            editor.chain().focus().toggleHeading({ level: 2 }).run()
          }
          className="h-8 w-8 p-0 text-slate-300 hover:text-white hover:bg-slate-600 data-[state=on]:bg-primary data-[state=on]:text-white"
        >
          <Heading2 className="h-4 w-4" />
        </Toggle>
        <Toggle
          size="sm"
          pressed={editor.isActive("heading", { level: 3 })}
          onPressedChange={() =>
            editor.chain().focus().toggleHeading({ level: 3 }).run()
          }
          className="h-8 w-8 p-0 text-slate-300 hover:text-white hover:bg-slate-600 data-[state=on]:bg-primary data-[state=on]:text-white"
        >
          <Heading3 className="h-4 w-4" />
        </Toggle>

        <Separator orientation="vertical" className="h-6 mx-1 bg-slate-500" />

        {/* Text Formatting */}
        <Toggle
          size="sm"
          pressed={editor.isActive("bold")}
          onPressedChange={() => editor.chain().focus().toggleBold().run()}
          className="h-8 w-8 p-0 text-slate-300 hover:text-white hover:bg-slate-600 data-[state=on]:bg-primary data-[state=on]:text-white"
        >
          <Bold className="h-4 w-4" />
        </Toggle>
        <Toggle
          size="sm"
          pressed={editor.isActive("italic")}
          onPressedChange={() => editor.chain().focus().toggleItalic().run()}
          className="h-8 w-8 p-0 text-slate-300 hover:text-white hover:bg-slate-600 data-[state=on]:bg-primary data-[state=on]:text-white"
        >
          <Italic className="h-4 w-4" />
        </Toggle>
        <Toggle
          size="sm"
          pressed={editor.isActive("underline")}
          onPressedChange={() => editor.chain().focus().toggleUnderline().run()}
          className="h-8 w-8 p-0 text-slate-300 hover:text-white hover:bg-slate-600 data-[state=on]:bg-primary data-[state=on]:text-white"
        >
          <UnderlineIcon className="h-4 w-4" />
        </Toggle>
        <Toggle
          size="sm"
          pressed={editor.isActive("strike")}
          onPressedChange={() => editor.chain().focus().toggleStrike().run()}
          className="h-8 w-8 p-0 text-slate-300 hover:text-white hover:bg-slate-600 data-[state=on]:bg-primary data-[state=on]:text-white"
        >
          <Strikethrough className="h-4 w-4" />
        </Toggle>

        <Separator orientation="vertical" className="h-6 mx-1 bg-slate-500" />

        {/* Lists */}
        <Toggle
          size="sm"
          pressed={editor.isActive("bulletList")}
          onPressedChange={() => editor.chain().focus().toggleBulletList().run()}
          className="h-8 w-8 p-0 text-slate-300 hover:text-white hover:bg-slate-600 data-[state=on]:bg-primary data-[state=on]:text-white"
        >
          <List className="h-4 w-4" />
        </Toggle>
        <Toggle
          size="sm"
          pressed={editor.isActive("orderedList")}
          onPressedChange={() => editor.chain().focus().toggleOrderedList().run()}
          className="h-8 w-8 p-0 text-slate-300 hover:text-white hover:bg-slate-600 data-[state=on]:bg-primary data-[state=on]:text-white"
        >
          <ListOrdered className="h-4 w-4" />
        </Toggle>
        <Toggle
          size="sm"
          pressed={editor.isActive("blockquote")}
          onPressedChange={() => editor.chain().focus().toggleBlockquote().run()}
          className="h-8 w-8 p-0 text-slate-300 hover:text-white hover:bg-slate-600 data-[state=on]:bg-primary data-[state=on]:text-white"
        >
          <Quote className="h-4 w-4" />
        </Toggle>

        <Separator orientation="vertical" className="h-6 mx-1 bg-slate-500" />

        {/* Alignment */}
        <Toggle
          size="sm"
          pressed={editor.isActive({ textAlign: "left" })}
          onPressedChange={() => editor.chain().focus().setTextAlign("left").run()}
          className="h-8 w-8 p-0 text-slate-300 hover:text-white hover:bg-slate-600 data-[state=on]:bg-primary data-[state=on]:text-white"
        >
          <AlignLeft className="h-4 w-4" />
        </Toggle>
        <Toggle
          size="sm"
          pressed={editor.isActive({ textAlign: "center" })}
          onPressedChange={() => editor.chain().focus().setTextAlign("center").run()}
          className="h-8 w-8 p-0 text-slate-300 hover:text-white hover:bg-slate-600 data-[state=on]:bg-primary data-[state=on]:text-white"
        >
          <AlignCenter className="h-4 w-4" />
        </Toggle>
        <Toggle
          size="sm"
          pressed={editor.isActive({ textAlign: "right" })}
          onPressedChange={() => editor.chain().focus().setTextAlign("right").run()}
          className="h-8 w-8 p-0 text-slate-300 hover:text-white hover:bg-slate-600 data-[state=on]:bg-primary data-[state=on]:text-white"
        >
          <AlignRight className="h-4 w-4" />
        </Toggle>

        <Separator orientation="vertical" className="h-6 mx-1 bg-slate-500" />

        {/* Clear Formatting */}
        <Button
          type="button"
          variant="ghost"
          size="sm"
          onClick={() => editor.chain().focus().clearNodes().unsetAllMarks().run()}
          className="h-8 w-8 p-0 text-slate-300 hover:text-white hover:bg-slate-600"
        >
          <RemoveFormatting className="h-4 w-4" />
        </Button>
      </div>

      {/* Editor Content */}
      <div className="bg-slate-800 [&_.ProseMirror]:min-h-[200px] [&_.ProseMirror]:p-4 [&_.ProseMirror]:text-white [&_.ProseMirror_h1]:text-2xl [&_.ProseMirror_h1]:font-bold [&_.ProseMirror_h1]:text-white [&_.ProseMirror_h1]:mb-4 [&_.ProseMirror_h2]:text-xl [&_.ProseMirror_h2]:font-bold [&_.ProseMirror_h2]:text-white [&_.ProseMirror_h2]:mb-3 [&_.ProseMirror_h3]:text-lg [&_.ProseMirror_h3]:font-bold [&_.ProseMirror_h3]:text-white [&_.ProseMirror_h3]:mb-2 [&_.ProseMirror_p]:text-slate-200 [&_.ProseMirror_p]:mb-3 [&_.ProseMirror_ul]:list-disc [&_.ProseMirror_ul]:pl-6 [&_.ProseMirror_ul]:text-slate-200 [&_.ProseMirror_ul]:mb-3 [&_.ProseMirror_ol]:list-decimal [&_.ProseMirror_ol]:pl-6 [&_.ProseMirror_ol]:text-slate-200 [&_.ProseMirror_ol]:mb-3 [&_.ProseMirror_blockquote]:border-l-4 [&_.ProseMirror_blockquote]:border-slate-500 [&_.ProseMirror_blockquote]:pl-4 [&_.ProseMirror_blockquote]:italic [&_.ProseMirror_blockquote]:text-slate-300 [&_.ProseMirror_strong]:text-white [&_.ProseMirror_strong]:font-bold">
        <EditorContent editor={editor} />
      </div>
    </div>
  );
};

export default RichTextEditor;
