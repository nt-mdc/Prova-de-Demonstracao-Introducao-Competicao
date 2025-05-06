let dragging = false;

        function setSplit(e) {
            updateSplit(e.clientX);
        }

        function startDrag(e) {
            dragging = true;
            updateSplit(e.clientX);
        }

        function stopDrag() {
            dragging = false;
        }

        function onDrag(e) {
            if (dragging) updateSplit(e.clientX);
        }

        function updateSplit(x) {
            const container = document.getElementById('compare-container');
            const rect = container.getBoundingClientRect();
            const percent = ((x - rect.left) / rect.width) * 100;
            container.style.setProperty('--split', percent + '%');
        }