#!/bin/bash
# sudo apt-get install stress

# Set the number of worker threads (adjust based on your CPU)
NUM_THREADS=$(nproc)

# Set the target CPU utilization percentage (80)
TARGET_UTILIZATION=90

# Calculate the load parameter for stress
LOAD_PARAMETER=$(echo "scale=2; $TARGET_UTILIZATION / 100 * $NUM_THREADS" | bc)

echo "Starting stress test to reach $TARGET_UTILIZATION% CPU utilization."

# Run stress with CPU load
stress --cpu $NUM_THREADS --timeout 200s &

# Wait for user input to stop the stress test
echo "Stress test started. Press Enter to stop."
read -r

# Stop the stress test
pkill stress

echo "Stress test stopped."
