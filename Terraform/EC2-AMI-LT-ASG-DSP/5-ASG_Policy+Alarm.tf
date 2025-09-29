# Create simple scaling policy for scaling up
resource "aws_autoscaling_policy" "scale_up" {
  for_each = toset(local.services)

  name                   = "ScaleUpPolicy-${each.value}"
  autoscaling_group_name = aws_autoscaling_group.service_asg[each.value].name
  policy_type            = "SimpleScaling"
  adjustment_type        = "ChangeInCapacity"
  scaling_adjustment     = 1   # Add 1 instance
  cooldown               = 300 # 5-minute cooldown to prevent rapid scaling
  
  depends_on = [aws_autoscaling_group.service_asg]
}

# Create simple scaling policy for scaling down
resource "aws_autoscaling_policy" "scale_down" {
  for_each = toset(local.services)

  name                   = "ScaleDownPolicy-${each.value}"
  autoscaling_group_name = aws_autoscaling_group.service_asg[each.value].name
  policy_type            = "SimpleScaling"
  adjustment_type        = "ChangeInCapacity"
  scaling_adjustment     = -1  # Remove 1 instance
  cooldown               = 300 # 5-minute cooldown to prevent rapid scaling

  depends_on = [aws_autoscaling_group.service_asg]
}

# CloudWatch Metric Alarm for scaling up (CPU > 50%)
resource "aws_cloudwatch_metric_alarm" "scale_up" {
  for_each = toset(local.services)

  alarm_name          = "ScaleUpAlarm-${each.value}"
  comparison_operator = "GreaterThanThreshold"
  evaluation_periods  = 2
  metric_name         = "CPUUtilization"
  namespace           = "AWS/EC2"
  period              = 60
  statistic           = "Average"
  threshold           = 50.0
  alarm_description   = "Triggers scaling up when CPU utilization exceeds 50% for ${each.value}"

  dimensions = {
    AutoScalingGroupName = aws_autoscaling_group.service_asg[each.value].name
  }

  alarm_actions = [aws_autoscaling_policy.scale_up[each.value].arn]

  depends_on = [aws_autoscaling_policy.scale_up]
}

# CloudWatch Metric Alarm for scaling down (CPU < 25%)
resource "aws_cloudwatch_metric_alarm" "scale_down" {
  for_each = toset(local.services)

  alarm_name          = "ScaleDownAlarm-${each.value}"
  comparison_operator = "LessThanThreshold"
  evaluation_periods  = 2
  metric_name         = "CPUUtilization"
  namespace           = "AWS/EC2"
  period              = 60
  statistic           = "Average"
  threshold           = 25.0
  alarm_description   = "Triggers scaling down when CPU utilization falls below 25% for ${each.value}"

  dimensions = {
    AutoScalingGroupName = aws_autoscaling_group.service_asg[each.value].name
  }

  alarm_actions = [aws_autoscaling_policy.scale_down[each.value].arn]

  depends_on = [aws_autoscaling_policy.scale_down]
}

# # Output Auto Scaling Group names
# output "autoscaling_groups" {
#   value       = { for service in local.services : service => aws_autoscaling_group.service_asg[service].name }
#   description = "Map of service names to their corresponding Auto Scaling Group names"
# }


# # Output the AMI IDs for each service
# output "amis" {
#   value = { for service in local.services : service => aws_ami_from_instance.service_ami[service].id }
#   description = "Map of service names to their corresponding AMI IDs"
# }