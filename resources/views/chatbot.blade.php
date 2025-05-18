<!DOCTYPE html>
<html lang="en">
<head>
    <title>Chatbot LLaMA</title>
</head>
<body>
    <h1>Chatbot LLaMA</h1>
    <form action="{{ url('/chatbot') }}" method="POST">
        @csrf
        <textarea name="prompt" rows="5" cols="60" placeholder="Tulis pertanyaanmu...">{{ old('prompt', session('prompt')) }}</textarea><br>
        <button type="submit">Kirim</button>
    </form>
    @if(session('response'))
        <div style="margin-top: 20px;">
            <strong>Jawaban:</strong>
            <p>{{ session('response') }}</p>
            <textarea id="markdown" style="display:none;">{{ session('response') }}</textarea>
            <div id="preview"></div>
        </div>
    @endif
    @if(session('error'))
        <p style="color: red;">Error: {{ session('error') }}</p>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        const markdown = document.getElementById('markdown')?.value;
        if (markdown) {
            document.getElementById('preview').innerHTML = marked.parse(markdown);
        }
    </script>
</body>
</html>