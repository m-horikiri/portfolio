import React, { useState } from "react";
import { Inertia } from "@inertiajs/inertia";
import { usePage } from "@inertiajs/react";
import styles from "./Todo.module.scss";

export default function Todo() {
    const { tasks } = usePage().props; // Laravel から渡されたタスク一覧
    const [newTask, setNewTask] = useState("");
    const [editTaskId, setEditTaskId] = useState(null);
    const [editTitle, setEditTitle] = useState("");

    // Laravel にタスクを送信
    const addTask = () => {
        if (newTask.trim() === "") return;
        Inertia.post("/tasks", { title: newTask });
        setNewTask(""); // 入力欄をクリア
    };

    // 編集ボタンを押したとき
    const startEditing = (task) => {
        setEditTaskId(task.id);
        setEditTitle(task.title);
    };

    // 編集をキャンセル
    const cancelEditing = () => {
        setEditTaskId(null);
        setEditTitle("");
    };

    // タスクを更新
    const updateTask = (id) => {
        Inertia.post(
            `/tasks/${id}`,
            { title: editTitle },
            {
                onSuccess: () => {
                    setEditTaskId(null);
                    setEditTitle("");
                },
            }
        );
    };

    // タスクを削除
    const deleteTask = (id) => {
        Inertia.delete(`/tasks/${id}`);
    };

    const toggleComplete = (id) => {
        Inertia.post(`/tasks/${id}/toggle`);
    };

    return (
        <div className={styles.container}>
            <h1>TODOアプリ 📝</h1>
            <div className={styles.addNewBox}>
                <input
                    type="text"
                    value={newTask}
                    onChange={(e) => setNewTask(e.target.value)}
                    placeholder="新しいタスクを入力..."
                />
                <button onClick={addTask}>追加</button>
            </div>
            <ul className={styles.taskList}>
                {tasks.map((task) => (
                    <li key={task.id}>
                        {editTaskId === task.id ? (
                            <>
                                <input
                                    type="checkbox"
                                    checked={task.completed}
                                    onChange={() => toggleComplete(task.id)}
                                />
                                <input
                                    type="text"
                                    value={editTitle}
                                    onChange={(e) =>
                                        setEditTitle(e.target.value)
                                    }
                                />
                                <button onClick={() => updateTask(task.id)}>
                                    保存
                                </button>
                                <button onClick={cancelEditing}>
                                    キャンセル
                                </button>
                                <button onClick={() => deleteTask(task.id)}>
                                    削除
                                </button>
                            </>
                        ) : (
                            <>
                                {task.title}
                                <button onClick={() => startEditing(task)}>
                                    編集
                                </button>
                            </>
                        )}
                    </li>
                ))}
            </ul>
        </div>
    );
}
