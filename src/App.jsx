import { useState, useEffect } from "react";
import "./styles/App.css";

const API = "http://localhost:3000/api";

function App() {
  const [bookmarks, setBookmarks] = useState([]);

  const fetchBookmarks = () => {
    fetch(`${API}/readAll.php`)
      .then((res) => res.json())
      .then((data) => setBookmarks(data));
  };

  useEffect(() => {
    fetchBookmarks();
  }, []);

  return (
    <div>
      <h1>Bookmarks</h1>
      <ul>
        {bookmarks.map((b) => (
          <li key={b.id}>
            <a href={b.url} target="_blank" rel="noreferrer">
              {b.title}
            </a>
          </li>
        ))}
      </ul>
    </div>
  );
}

export default App;
