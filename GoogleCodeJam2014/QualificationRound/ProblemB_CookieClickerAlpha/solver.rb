require 'pp'

def read_input(file)
  File.open(file)
end

def make_test_case(input)
  test_cases = Array.new

  test_case_num = input.gets.strip
  test_case_num.to_i.times do |case_num|
    test_case = Hash.new

    test_case = Hash[*[['C', 'F', 'X'], input.gets.strip.split.map {|i| i.to_f }].transpose.flatten]

    test_cases << test_case
  end
  test_cases
end

def solver(test_case)
  elapse_time     = 0
  elapse_time_pre = 0
  div_x_pre       = nil
  div_c_pre       = nil
  increase        = 2

  loop do
    div_x = test_case['X'] / increase
    div_c = test_case['C'] / increase

    return elapse_time += div_x         if div_x < div_c
    return elapse_time_pre += div_x_pre if !div_x_pre.nil? && !div_x_pre.nil? && div_x_pre < div_c_pre + div_x

    elapse_time_pre =  elapse_time
    div_x_pre       =  div_x
    div_c_pre       =  div_c
    elapse_time     += div_c
    increase        += test_case['F']
  end
end

input_file = ARGV.shift
input_file = 'sample-attempt.in' if input_file.nil?
input      = read_input(input_file)

test_cases = make_test_case(input)
test_cases.each_with_index do |test_case, num|
   puts "Case ##{num + 1}: #{solver test_case}"
end


