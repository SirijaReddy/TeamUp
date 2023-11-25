let boardCount = 0;

        function addBoard() {
            boardCount++;
            const boardContainer = document.querySelector('.board-container');
            const newBoard = document.createElement('div');
            newBoard.className = 'board';
            newBoard.innerHTML = `
                <h2>Meeting ${boardCount}</h2>
                <div class="task" draggable="true">Start Time</div>
                <div class="task" draggable="true">End Time</div>
                <div class="task" draggable="true">Subject</div>
                <div class="task" draggable="true">Team ID</div>
                <div class="task" draggable="true">Communication Type</div>
            `;
            boardContainer.appendChild(newBoard);

            // Enable drag-and-drop for the new tasks
            const tasks = newBoard.querySelectorAll('.task');
            tasks.forEach(task => {
                task.addEventListener('dragstart', e => {
                    e.dataTransfer.setData('text/plain', task.textContent);
                });
            });

            // Enable drag-and-drop functionality for the new board
            newBoard.addEventListener('dragover', e => {
                e.preventDefault();
            });

            newBoard.addEventListener('drop', e => {
                e.preventDefault();
                const data = e.dataTransfer.getData('text/plain');
                const newTask = document.createElement('div');
                newTask.className = 'task';
                newTask.textContent = data;
                newBoard.appendChild(newTask);
            });
        }

//CREATE FUNCTION CalculateTimeDifferenceInSeconds(start_time DATETIME, end_time DATETIME) 
//RETURNS INT BEGIN DECLARE diff_seconds INT; SET diff_seconds = TIMESTAMPDIFF(SECOND, start_time, end_time); RETURN diff_seconds; END;;