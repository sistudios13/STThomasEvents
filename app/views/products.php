
    <link rel="stylesheet" href="https://unpkg.com/@alisaitteke/seatmap-canvas/dist/seatmap.canvas.css">

    <div class="seatmap-container" style="width: 100%; height: 600px;"></div>
    
    <script type="module">
        import { SeatmapCanvas } from 'https://unpkg.com/@alisaitteke/seatmap-canvas/dist/esm/seatmap.canvas.js';
        
        // Configuration
        const config = {
            resizable: true,
            style: {
                seat: {
                    radius: 12,
                    color: "#6796ff",
                    hover: "#5671ff",
                    selected: "#56aa45"
                }
            }
        };
        
        // Initialize
        const seatmap = new SeatmapCanvas(".seatmap-container", config);
        
        // Data
        const data = {
            blocks: [
                {
                    id: 1,
                    title: "Section A",
                    color: "#2c2828",
                    seats: [
                        { id: 1, x: 0, y: 0, title: "A1", salable: true },
                        { id: 2, x: 30, y: 0, title: "A2", salable: true },
                        { id: 3, x: 60, y: 0, title: "A3", salable: true }
                    ]
                }
            ]
        };
        
        // Set data
        seatmap.setData(data);
        
        // Handle seat clicks
        seatmap.addEventListener("seat_click", (seat) => {
            if (seat.selected) {
                seatmap.seatUnselect(seat);
            } else {
                seatmap.seatSelect(seat);
            }
        });
    </script>
