package routes

import (
	"net/http"
	"strconv"
	"sync"
	"time"

	"github.com/gin-gonic/gin"
)

var globalLock sync.Mutex // Global lock for all APIs

func BlockWhenSleeping() gin.HandlerFunc {
	return func(c *gin.Context) {
		locked := !globalLock.TryLock() // Check if locked
		if locked {
			c.JSON(http.StatusServiceUnavailable, gin.H{"error": "Service is temporarily unavailable. Please try again later."})
			c.Abort()
			return
		}
		globalLock.Unlock() // Immediately unlock if not in sleep
		c.Next()
	}
}

func health(c *gin.Context) {
	c.JSON(200, gin.H{"status": "healthy"})
}
func ready(c *gin.Context) {
	c.JSON(200, gin.H{"status": "ready"})
}
func sleep(c *gin.Context) {
	sleepTimeStr := c.Param("time")
	sleepTime, err := strconv.Atoi(sleepTimeStr)
	if err != nil || sleepTime <= 0 {
		sleepTime = 20
	}

	globalLock.Lock()         // Lock to block other APIs
	defer globalLock.Unlock() // Unlock after sleep

	time.Sleep(time.Duration(sleepTime) * time.Second)

	c.JSON(200, gin.H{"status": "slept for", "duration": sleepTime})
}
