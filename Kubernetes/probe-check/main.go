package main

import (
	"fmt"
	"os"
	"strconv"
	"time"

	"github.com/aakkiiff/probes/routes"
	"github.com/gin-gonic/gin"
)

func main() {
	gin.SetMode(gin.ReleaseMode)
	server := gin.Default()
	server.Use(routes.BlockWhenSleeping())
	routes.RegisterRoutes(server)
	sleepTimeStr := os.Getenv("SLEEP_TIME")
	sleepTime, err := strconv.Atoi(sleepTimeStr)
	if err != nil || sleepTime <= 0 {
		sleepTime = 2
	}
	fmt.Println("sleeping", sleepTime, "seconds")

	time.Sleep(time.Duration(sleepTime) * time.Second)

	server.Run(":8080")

}
