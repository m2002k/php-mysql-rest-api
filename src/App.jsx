import { useState, useEffect } from "react";
import "./styles/App.css";

const API = "http://localhost:3000/api";

function App() {
  const [bookmarks, setBookmarks] = useState([]);
  const [title, setTitle] = useState("");
  const [url, setUrl] = useState("");
  const [editingId, setEditingId] = useState(null);

  const fetchBookmarks = () => {
    fetch(`${API}/readAll.php`)
      .then((res) => res.json())
      .then((data) => setBookmarks(data));
  };

  useEffect(() => {
    fetchBookmarks();
  }, []);

  const handleSubmit = async (e) => {
    e.preventDefault();

    const payload = { title, url };

    const endpoint = editingId ? "update.php" : "create.php";
    if (editingId) payload.id = editingId;

    await fetch(`${API}/${endpoint}`, {
      method: "POST", // PHP expects POST
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(payload),
    });

    setTitle("");
    setUrl("");
    setEditingId(null);
    fetchBookmarks();
  };

  const handleEdit = (bookmark) => {
    setTitle(bookmark.title);
    setUrl(bookmark.url);
    setEditingId(bookmark.id);
  };

  const handleDelete = async (id) => {
    await fetch(`${API}/delete.php`, {
      method: "POST", // PHP expects POST
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id }),
    });

    fetchBookmarks();
  };

  return (
    <div>
      <h1>Bookmarks</h1>
      <form onSubmit={handleSubmit}>
        <input
          placeholder="Title"
          value={title}
          onChange={(e) => setTitle(e.target.value)}
        />
        <input
          placeholder="URL"
          value={url}
          onChange={(e) => setUrl(e.target.value)}
        />
        <button type="submit">{editingId ? "Update" : "Add"}</button>
      </form>

      <ul>
        {bookmarks.map((b) => (
          <li key={b.id}>
            <a href={b.url} target="_blank" rel="noreferrer">
              {b.title}
            </a>
            <button onClick={() => handleEdit(b)}>✏️</button>
            <button onClick={() => handleDelete(b.id)}>❌</button>
          </li>
        ))}
      </ul>
    </div>
  );
}

export default App;
