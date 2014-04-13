require 'pp'

def read_input(file)
  File.open(file)
end

def make_test_case(input)
  test_cases = Array.new

  test_case_num = input.gets.strip
  test_case_num.to_i.times do |case_num|
    test_case = Hash.new

    test_case['1st_arrangement_pos'] = input.gets.strip.to_i - 1
    test_case['1st_arrangement']     = 4.times.map{ input.gets.strip.split }
    test_case['2nd_arrangement_pos'] = input.gets.strip.to_i - 1
    test_case['2nd_arrangement']     = 4.times.map{ input.gets.strip.split }

    test_cases << test_case
  end
  test_cases
end

def solver(test_case)
  candidate_1st = test_case['1st_arrangement'][test_case['1st_arrangement_pos']]
  candidate_2nd = test_case['2nd_arrangement'][test_case['2nd_arrangement_pos']]

  result = candidate_1st & candidate_2nd
  return result               if result.size == 1
  return 'Bad magician!'      if result.size > 1
  return 'Volunteer cheated!' if result.size == 0
  return "Something is wrong."
end

input_file = ARGV.shift
input_file = 'sample-attempt.in' if input_file.nil?
input      = read_input(input_file)

test_cases = make_test_case(input)
test_cases.each_with_index do |test_case, num|
   puts "Case ##{num + 1}: #{solver test_case}"
end


