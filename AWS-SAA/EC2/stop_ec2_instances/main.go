package main

import (
	"context"
	"fmt"
	"log"
	"time"

	"github.com/aws/aws-sdk-go-v2/aws"
	"github.com/aws/aws-sdk-go-v2/config"
	"github.com/aws/aws-sdk-go-v2/service/ec2"
	"github.com/aws/aws-sdk-go-v2/service/ec2/types"
)

// Function to list running EC2 instances in a specific region and terminate those running for more than 1 hour
func listRunningInstancesInRegion(ctx context.Context, region string, cfg aws.Config) error {
	// Update the config with the specific region
	cfg.Region = region

	// Create an EC2 client
	svc := ec2.NewFromConfig(cfg)

	// Define filter for running instances
	filters := []types.Filter{
		{
			Name:   aws.String("instance-state-name"),
			Values: []string{"running", "stopped"},
		},
	}

	// Call DescribeInstances API
	input := &ec2.DescribeInstancesInput{
		Filters: filters,
	}

	result, err := svc.DescribeInstances(ctx, input)
	if err != nil {
		return fmt.Errorf("failed to describe instances in region %s: %v", region, err)
	}

	// Check if any instances are found
	// if len(result.Reservations) == 0 {
	// 	// fmt.Printf("No running instances in region: %s\n", region)
	// 	return nil
	// }

	// Loop through the result and check instance running duration
	// fmt.Printf("Instances in region %s:\n", region)
	for _, reservation := range result.Reservations {
		for _, instance := range reservation.Instances {
			instanceID := *instance.InstanceId
			state := instance.State.Name
			launchTime := *instance.LaunchTime

			// Calculate how long the instance has been running
			duration := time.Since(launchTime)

			oneHour := time.Hour
			if duration > oneHour {
				fmt.Printf("Instance %s has been running for more than 1 hour in %s. Terminating...\n", instanceID,region)

				// Terminate the instance
				_, err := svc.TerminateInstances(ctx, &ec2.TerminateInstancesInput{
					InstanceIds: []string{instanceID},
				})

				if err != nil {
					fmt.Printf("Error terminating instance %s: %v\n", instanceID, err)
				} else {
					fmt.Printf("Instance %s has been terminated.\n", instanceID)
				}
			} else {
				fmt.Printf("Instance %s has been running for less than 1 hour in %s.\n", instanceID,region)
			}

			// Print instance details
			fmt.Printf("  Instance ID: %s\n", instanceID)
			fmt.Printf("  State: %s\n", state)
			fmt.Printf("  Running for: %v\n", duration)
			fmt.Println("-----------")
		}
	}

	return nil
}

func main() {
	ctx := context.TODO()

	// Load the default AWS config
	cfg, err := config.LoadDefaultConfig(ctx)
	if err != nil {
		log.Fatalf("unable to load SDK config, %v", err)
	}

	// Create an EC2 client to get regions
	ec2Client := ec2.NewFromConfig(cfg)

	// Describe all regions to get the list of available regions
	regionsOutput, err := ec2Client.DescribeRegions(ctx, &ec2.DescribeRegionsInput{})
	if err != nil {
		log.Fatalf("failed to describe regions: %v", err)
	}

	// Iterate over all regions and list running instances
	for _, region := range regionsOutput.Regions {
		regionName := *region.RegionName
		// fmt.Printf("\nChecking region: %s\n", regionName)
		err := listRunningInstancesInRegion(ctx, regionName, cfg)
		if err != nil {
			fmt.Printf("Error in region %s: %v\n", regionName, err)
		}
	}
}
