package routes

import "github.com/gin-gonic/gin"

func RegisterRoutes(server *gin.Engine) {

	server.GET("/health", health)
	server.GET("/ready", ready)
	server.GET("/sleep/:time", sleep)

}
